

var vURL = null;
let reload = false;



jQuery(function() {
	vURL = $('#main-url').data('url');

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

    $('.collapse').on('show.bs.collapse',function(){
        reload = true;
    });


    $(document).on('click','.configuration-collapse',function(){
        if (reload) {
            reloadConfigurationContainer($(this).data('id'));
        }
    });

    $(document).on('click','.add-configuration',function(){
        getConfigurationForm($(this).data('id'), null);
    });

    $(document).on('click','#btn-save-configuration',function(){

        if ($('#form-configuration').valid()) {
            saveConfiguration();
        }

    });

    $(document).on('click','.edit-configuration',function(){
        getConfigurationForm($(this).data('configuration-id'), $(this).data('contract-configuration-id'));
    });

    $(document).on('click','.delete-configuration',function(){
        deleteConfiguration($(this).data('configuration-id'), $(this).data('contract-configuration-id'));
    });

    $(document).on('change','#fk_id_consumable_group',function(){
        getConsumables($(this).val());
    });


    $(document).on('click','#btn-search-consumable',function(){

        if ($('#search_string').val().length < 2) {
            toastr.warning($('#msg-write-more-than-one-letter').val(), $('#msg-something-went-wrong').val());
        }else{
            searchConsumables($('#search_string').val());
        }
    });
});

function getConfigurationForm(id_configuration, id_contract_configuration){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        id_configuration : id_configuration,
        id_contract : $('#id_contract').val(),
        id_contract_configuration : id_contract_configuration
    }

    $.post(
        vURL+"/invoicing/configurationSubtype/getForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-contract-config-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                })

                $('body').loading('stop');
                refreshInputs();
                validateForm("#form-configuration",[],[]);
            } else {
                $('body').loading('stop');
                Swal.fire({
                    type: 'error',
                    title: $('#msg-something-went-wrong').val(),
                    text: $('#msg-error-getting-data').val(),
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

function getConsumables(id_group){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        id_group : id_group
    }

    $.post(
        vURL+"/production/consumable/getByGroupId",
        domData,
        function(data)
        {
            $('body').loading('stop');

            if (data.success) {
                var options = "";

                $.each(data.consumables, function(i, product) {
                    options += "<option value='" + i + "' >" + product + "</option>";
                });

                $("#fk_id_product").html(options);
                $(".selectpicker").selectpicker('refresh');

                refreshInputs();
            } else {
                $('body').loading('stop');
                Swal.fire({
                    type: 'error',
                    title: $('#msg-something-went-wrong').val(),
                    text: $('#msg-error-getting-data').val(),
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

function searchConsumables(input_string){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        input_string : input_string
    }

    $.post(
        vURL+"/production/consumable/searchByString",
        domData,
        function(data)
        {
            $('body').loading('stop');

            if (data.success) {
                var options = "";

                $.each(data.consumables, function(i, product) {
                    options += "<option value='" + i + "' >" + product + "</option>";
                });

                $("#fk_id_product").html(options);
                $(".selectpicker").selectpicker('refresh');

                refreshInputs();
            } else {
                $('body').loading('stop');
                Swal.fire({
                    type: 'error',
                    title: $('#msg-something-went-wrong').val(),
                    text: $('#msg-error-getting-data').val(),
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

function saveConfiguration() {

    let myForm = document.getElementById('form-configuration');
    var domData = new FormData(myForm);

    $('body').loading({
      message: $('#msg-loading').val()
    });

    $.ajax({

        url: vURL+'/invoicing/contractConfiguration/save',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: domData,
        success: function(data){
          $('body').loading('stop');

            if (data.status == 200) {

                toastr.success(data.message, data.title);

                reloadConfigurationContainer(data.id_configuration);
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

function deleteConfiguration(id_configuration, id_contract_configuration) {

    var formData = new FormData();
    formData.append("id_configuration", id_configuration);
    formData.append("id_contract_configuration", id_contract_configuration);

    Swal.fire({
        title: $('#msg-contract-config-delete').val(),
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

                url: vURL+'/invoicing/contractConfiguration/delete',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    $('body').loading('stop');

                    if (data.status == 200) {
                        toastr.success(data.message, data.title);
                        reloadConfigurationContainer(data.id_configuration);
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


function reloadConfigurationContainer(id_configuration){
    reload = false;

    var domData = {
        id_configuration : id_configuration,
        id_contract : $('#id_contract').val()
    }

    $.post(
        vURL+"/invoicing/contractConfiguration/getList",
        domData,
        function(data)
        {
            if (data.success) {

                $('#container-configuration-'+data.id_configuration).html(data.html);
                refreshInputs();

            } else {
                Swal.fire({
                    type: 'error',
                    title: $('#msg-something-went-wrong').val(),
                    text: $('#msg-error-getting-data').val(),
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    ).fail(function(data) {
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

function updateRangeInput(elem) {
    $('#'+$(elem).attr("id")+'_container').text($(elem).val());
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

    if($("#table-diameters").length > 0){
        refreshTable("table-diameters");
    }

    if($("#table-activities").length > 0){
        refreshTable("table-activities");
    }

    if($("#table-products").length > 0){
        refreshTable("table-products");
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

function refreshTable(string_id_table) {
    table_contracts = $('#'+string_id_table).DataTable({
        language: {
            "url": vURL+"/js/general/datatables/"+current_lang+".json"
        },
        processing: true,
        serverSide: false,
        responsive: false,
        "destroy": true,
        scrollX: 400,
        scrollY: 380,
        scrollCollapse: true,
        dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
            }
            ],
        pageLength: 15,
    });
}
