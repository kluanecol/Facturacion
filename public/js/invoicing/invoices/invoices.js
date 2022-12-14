

var vURL = null;
var vURL_INVOICING = null;
let id_machines = [];
let initial_period = null;
let end_period = null;
let id_pits = [];
let id_contract = null;
let table_invoices = null;

jQuery(function() {

	vURL = $('#main-url').data('url');
    vURL_INVOICING = $('#main-url-init').data('url');

    refreshInvoicesTable();
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
    }

    $(document).on('click','.add-invoice',function(){
        getInvoiceForm($('#id_contract').val());
    });

    $(document).on('click','.add-new-version',function(){
        getNewInvoiceVersionForm($(this).data('id'));
    });

    $(document).on('click','#btn-search-pits',function(){
        domData = getFormFields();

        if (id_machines != '' && initial_period != '' && end_period != '') {
            getPits(domData);
        }else{
            toastr.warning($('#msg-cant-filter-subtitle').val(), $('#msg-cant-filter-title').val()+'!');
        }
    });

    $(document).on('click','#btn-save-invoice',function(){

        if ($('#form-invoice').valid()) {
            saveInvoice('form-invoice');
        }

    });

    $(document).on('click','#btn-save-invoice-configuration',function(){

        saveInvoiceConfiguration('form-invoice-configuration');

    });


    $(document).on('click','.delete-invoice',function(){
        deleteInvoice($(this).data('id'));
    });

    $(document).on('click','.config-invoice',function(){
        configInvoice($(this).data('id'));
    });

    $(document).on('click','.save-configurated-invoice',function(){
        saveConfiguratedInvoice($(this).data('id'));
    });

});

function getInvoiceForm(id_contract){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        id_contract : id_contract,
    }

    $.get(
        vURL+"/invoicing/invoice/getGeneralForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-invoice-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                })

                $('body').loading('stop');
                refreshInputs();
                validateForm("#form-invoice",[],[]);
            } else {
                $('body').loading('stop');
                Swal.fire({
                    type: 'warning',
                    title:  $('#msg-something-went-wrong').val(),
                    text: $('#msg-invoice-version-created').val(),
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    ).fail(function(data) {
        $('body').loading('stop');
        if(data.status == 419){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-session-expired').val(),
                showConfirmButton: false,
                timer: 2000
            }).then(()=>{
                location.reload();
            });

        }else if(data.status == 500){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-contact-support').val(),
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}

function getFormFields() {
    id_machines = $('#json_fk_machines').val();
    initial_period = $('#initial_period').val();
    end_period = $('#end_period').val();
    id_contract = $('#fk_id_contract').val();

    var domData = {
        'id_machines' : id_machines,
        'initial_period' : initial_period,
        'end_period' : end_period,
        'id_contract' : id_contract
    };

    return domData;
}

function getNewInvoiceVersionForm(id_invoice){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        id_invoice : id_invoice,
    }

    $.get(
        vURL+"/invoicing/invoice/getNewInvoiceVersionForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-invoice-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                })

                $('body').loading('stop');
                refreshInputs();
                validateForm("#form-invoice",[],[]);
            } else {
                $('body').loading('stop');
                Swal.fire({
                    type: 'warning',
                    title:  $('#msg-invoice-version-created').val(),
                    text: $('#msg-something-went-wrong').val(),
                    showConfirmButton: true
                })
            }
        }
    ).fail(function(data) {
        $('body').loading('stop');
        if(data.status == 419){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-session-expired').val(),
                showConfirmButton: false,
                timer: 2000
            }).then(()=>{
                location.reload();
            });

        }else if(data.status == 500){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-contact-support').val(),
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}

function getPits(domData){

    $('body').loading({
        message: $('#msg-loading').val()
    });

    $.get(
        vURL+"/invoicing/invoice/getPitsBySearch",
        domData,
        function(data)
        {
            $('body').loading('stop');

            if (data.success) {
                var options = "";

                if (data.pits.length > 0) {
                    $.each(data.pits, function(i, pit) {
                        options += "<option value='" + pit + "' >" + pit + "</option>";
                    });

                    $("#json_fk_pits").html(options);
                    $(".selectpicker").selectpicker('refresh');

                    refreshInputs();
                }else{
                    toastr.info($('#msg-error-getting-data').val(), $('#msg-invoice-no-pits').val());
                }

            } else {
                $('body').loading('stop');
                toastr.error($('#msg-error-getting-data').val(), $('#msg-something-went-wrong').val());
            }
        }
    ).fail(function(data) {
        $('body').loading('stop');
        if(data.status == 419){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-session-expired').val(),
                showConfirmButton: false,
                timer: 2000
            }).then(()=>{
                location.reload();
            });

        }else if(data.status == 500){
            Swal.fire({
                type: 'error',
                title: $('#msg-something-went-wrong').val(),
                text: $('#msg-contact-support').val(),
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}

function saveInvoice(str_id_form) {

    let myForm = document.getElementById(str_id_form);
    var domData = new FormData(myForm);

    $('body').loading({
      message: $('#msg-loading').val()
    });

    $.ajax({
        url: vURL+'/invoicing/invoice/save',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: domData,
        success: function(data){
          $('body').loading('stop');

            if (data.status == 200) {
                Swal.fire({
                    title: data.title,
                    html: data.message,
                    type: `success`,
                    showConfirmButton: false,
                    timer: 3000
                });

                table_invoices.ajax.reload();
            }
            else if(data.status == 400){
                toastr.warning(data.message, data.title);
            }
            else{
                toastr.error(data.message, data.title);
            }
        },
        error: function(data){
            $('body').loading('stop');

            if(data.status == 419){
                Swal.fire({
                  title: $('#msg-something-went-wrong').val(),
                  html: $('#msg-session-expired').val(),
                  type: `error`,
                  showConfirmButton: false,
                  timer: 3000
                }).then(()=>{
                  location.reload();
                });
            }else if(data.status == 500){
                Swal.fire({
                    title: $('#msg-something-went-wrong').val(),
                    html: $('#msg-contact-support').val(),
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });
}

function saveInvoiceConfiguration(str_id_form) {


    var invoice_configurations = elementsToArrayByElement($('#tbody-configurations'), 'tr');


    var formData = {
        'invoice_configurations' : invoice_configurations,
        'fk_id_invoice': $('#fk_id_invoice').val(),
        'fk_id_contract': $('#fk_id_contract').val()
    }

    $.post(
        vURL+'/invoicing/invoice/saveConfiguration',
        formData,
        function(data) {
            if (data.status == 200) {
                Swal.fire({
                    title: data.title,
                    html: data.message,
                    type: data.type,
                    showConfirmButton: false,
                    timer: 1000
                });
            }
            table_invoices.ajax.reload();
        }
    ).fail(function(data) {

        if(data.status == 419){
            Swal.fire({
              title: $('#msg-something-went-wrong').val(),
              html: $('#msg-session-expired').val(),
              type: `error`,
              showConfirmButton: false,
              timer: 3000
            }).then(()=>{
              location.reload();
            });
        }else if(data.status == 500){
            Swal.fire({
                title: $('#msg-something-went-wrong').val(),
                html: $('#msg-contact-support').val(),
                type: `error`,
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}


function deleteInvoice(id_invoice) {

    var formData = new FormData();
    formData.append("id_invoice", id_invoice);

    Swal.fire({
        title: $('#msg-invoice-delete').val(),
        type: 'question',
        showCancelButton: true,
        confirmButtonText: $('#msg-delete').val(),
        cancelButtonText: $('#msg-cancel').val(),
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value == true) {
            $('body').loading({
                message: $('#msg-loading').val()
            });

            $.ajax({

                url: vURL+'/invoicing/invoice/delete',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    $('body').loading('stop');

                    if (data.status == 200) {
                        toastr.success(data.message, data.title);
                        table_invoices.ajax.reload();
                    }
                    else if(data.status == 400){
                        toastr.warning(data.message, data.title);
                    }
                    else{
                        toastr.error(data.message, data.title);
                    }
                },
                error: function(data){
                    $('body').loading('stop');

                    if(data.status == 419){
                        Swal.fire({
                            title: $('#msg-something-went-wrong').val(),
                            html: $('#msg-session-expired').val(),
                            type: `error`,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(()=>{
                            location.reload();
                        });
                    }else if(data.status == 500){
                        Swal.fire({
                            title: $('#msg-something-went-wrong').val(),
                            html: $('#msg-contact-support').val(),
                            type: `error`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });

        }
    })

}


function configInvoice(id_invoice) {

    var formData = new FormData();
    formData.append("id_invoice", id_invoice);

    $('body').loading({
        message: $('#msg-loading').val()
    });

    $.ajax({

        url: vURL+'/invoicing/invoice/getConfigurationInvoiceForm/'+id_invoice,
        type: 'GET',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            $('body').loading('stop');

            if (data.status == 200) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-invoice-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                })

                $('body').loading('stop');
                refreshInputs();
                validateForm("#form-invoice-configuration",[],[]);

            }
            else if(data.status == 400){
                toastr.warning(data.message, data.title);
            }
            else{
                toastr.error(data.message, data.title);
            }
        },
        error: function(data){
            $('body').loading('stop');

            if(data.status == 419){
                Swal.fire({
                    title: $('#msg-something-went-wrong').val(),
                    html: $('#msg-session-expired').val(),
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                }).then(()=>{
                    location.reload();
                });
            }else if(data.status == 500){
                Swal.fire({
                    title: $('#msg-something-went-wrong').val(),
                    html: $('#msg-contact-support').val(),
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });

}

function saveConfiguratedInvoice(id_invoice) {

    var formData = new FormData();
    formData.append("id_invoice", id_invoice);

    Swal.fire({
        title: $('#msg-invoice-save-configurated').val(),
        type: 'question',
        showCancelButton: true,
        confirmButtonText: $('#msg-invoice-save').val(),
        cancelButtonText: $('#msg-cancel').val(),
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value == true) {
            $('body').loading({
                message: $('#msg-loading').val()
            });

            $.ajax({

                url: vURL+'/invoicing/invoice/saveConfiguratedInvoice',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    $('body').loading('stop');

                    if (data.status == 200) {
                        toastr.success(data.message, data.title);
                        table_invoices.ajax.reload();

                    }
                    else if(data.status == 400){
                        toastr.warning(data.message, data.title);
                    }
                    else{
                        toastr.error(data.message, data.title);
                    }
                },
                error: function(data){
                    $('body').loading('stop');

                    if(data.status == 419){
                        Swal.fire({
                            title: $('#msg-something-went-wrong').val(),
                            html: $('#msg-session-expired').val(),
                            type: `error`,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(()=>{
                            location.reload();
                        });
                    }else if(data.status == 500){
                        Swal.fire({
                            title: $('#msg-something-went-wrong').val(),
                            html: $('#msg-contact-support').val(),
                            type: `error`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });

        }
    })



}

function refreshInputs(){
    $('[data-toggle="tooltip"]').tooltip();
    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        language: 'es',
        autoclose: true,
    });

    $("select.selectpicker").selectpicker('refresh');

    $('[data-toggle="tooltip"]').tooltip();

    if($("#table-drilling").length > 0){
        refreshTable("table-drilling");
    }

    if($("#table-casing").length > 0){
        refreshTable("table-casing");
    }

    if($("#table-hole-inclination").length > 0){
        refreshTable("table-hole-inclination");
    }

    if($("#table-activities").length > 0){
        refreshTable("table-activities");
    }

    if($("#table-products").length > 0){
        refreshTable("table-products");
    }

    if($("#table-charges").length > 0){
        refreshTable("table-charges");
    }
}

function validateForm(id,rules,custom_messages){

    if(id==undefined || $(id).length == 0 ){
      return false;
    }else{
        rules = (rules == undefined) ? [] : rules;
        custom_messages = (custom_messages == undefined) ? [] : custom_messages;

        jQuery.validator.addMethod("biggerthanInitialRange", function (value, element) {
            return this.optional(element) || parseInt(value) > parseInt($("#initial_range").val());
        }, jQuery.validator.format($('#msg-final-range-greater').val()));

        $.validator.addClassRules("is_required", {
            required: true,
        });

        $(id).validate().destroy();

        $.validator.addClassRules("vc_max", {
            maxlength: 25
        });

        $(id).validate({
            //ignore: [],
            rules: rules,
            messages: custom_messages,
            errorPlacement : function(error, element) {
                $(element).closest('.form-group').find('.help-block').html(error.html());
                $(element).closest('tr').find('.error-subtotal .help-block').html(error.html());

            },
            highlight : function(element) {
                $(element).closest('.form-group').removeClass('has-info').addClass('has-error');
                $(element).closest('tr').find('.error-subtotal .form-group').removeClass('has-info').addClass('has-error');
                $(element).closest('div').find('.alert').removeClass('alert-note').addClass('alert-danger');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-info');
                $(element).closest('.form-group').find('.help-block').html('');

                $(element).closest('tr').find('.error-subtotal .form-group').removeClass('has-error').addClass('has-info');
                $(element).closest('tr').find('.error-subtotal .help-block').html('');

                $(element).closest('div').find('.alert').removeClass('alert-danger').addClass('alert-note');
            }

        });

    }
}

function refreshInvoicesTable() {
    var groupColumn = 1;

    var domData = {
        'id_contract' : $('#id_contract').val()
    };

    table_invoices = $('#table-invoices').DataTable({
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="7">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        },
        language: {
            "url": vURL+"/js/general/datatables/"+current_lang+".json"
        },
        order: [[2, 'desc']],
        rowGroup: {
            startRender: null,
            endRender: function ( rows, group ) {
                return group +' ('+rows.count()+')';
            },
            dataSrc: 1
        },
        processing: true,
        serverSide: false,
        ordering: false,
        responsive: true,
        "destroy": true,
        "ajax": {
            "url": vURL+"/invoicing/invoice/search",
            "type": 'POST',
            "data": domData
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'period', name: 'period'},
            {data: 'code', name: 'code'},
            {data: 'version', name: 'version'},
            {data: 'machines', name: 'machines'},
            {data: 'pits', name: 'pits'},
            {data: 'state', name: 'state'},
            {data: 'options', name: 'options'}
        ],
        dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
            }
            ],

    });
}

function elementsToArrayByElement(container, row) {
    var data = [];
    container.find(row).each(function(i, element) {
        let fields = elementsToArray(element);
        if (Object.keys(fields).length != 0)
            data.push(fields);
    });
    return data;
}

function elementsToArray(element) {
    let fields = {};
    $(element).find("input,textarea").each(function(i, input) {
        if (input.type == 'checkbox') {
            fields[input.name] = input.checked;
        } else {
            fields[input.name] = input.value;
        }
    });

    $(element).find("select").each(function(i, input) {
        fields[input.name] = input.value;
    });

    return fields;
}
