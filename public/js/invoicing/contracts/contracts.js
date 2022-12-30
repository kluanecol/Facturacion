

var vURL = null;
let table_contracts = 0;
let id_project = [];
let year = [];
let id_client = [];

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


    $(document).on('click','#search-contracts',function(){
        domData = getFormFields();

        if (id_project != '' && year != '' && id_client != '') {
            refreshContractsTable(domData);
        }else{
            Swal.fire({
                type: 'warning',
                title: $('#msg-cant-filter-title').val()+'!',
                text: $('#msg-cant-filter-subtitle').val()
            });
        }
    });

    $(document).on('click','.add-contract',function(){
        getContractForm();
    });

    $(document).on('click','#btn-add',function(){

        if ($("#form-contract").valid()) {
            saveContract();
        }

    });

    $(document).on('click','.edit-contract',function(){
        getContractForm($(this).data('id'));
    });

    $(document).on('click','.delete-contract',function(){
        deleteContract($(this).data('id'));
    });


});

function getContractForm(id_contract = null){

    var domData = {
        id_contract : id_contract
    }

    $.get(
        vURL+"/invoicing/contract/getContractForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-contract-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                  })

                refreshInputs();
                validateForm("#form-contract",[],[]);
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

function saveContract() {

    let myForm = document.getElementById('form-contract');
    var domData = new FormData(myForm);

    $('body').loading({
      message: $('#msg-loading').val()
    });

    $.ajax({

        url: vURL+'/invoicing/contract/save',
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
                    type: data.type,
                    showConfirmButton: true,
                });
                domData = getFormFields();

                if (!data.offline) {
                    refreshContractsTable(domData);
                }
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

function deleteContract(id_contract) {

    var formData = new FormData();
    formData.append("id_contract", id_contract);

    Swal.fire({
        title: $('#msg-contract-delete').val(),
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

                url: vURL+'/invoicing/contract/delete',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    $('body').loading('stop');

                    if (data.status == 200) {
                        Swal.fire({
                            title: data.title,
                            html: data.message,
                            type: data.type,
                            showConfirmButton: true,
                        });

                        table_contracts.ajax.reload();

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


function refreshContractsTable(postData) {
    table_contracts = $('#table-contracts').DataTable({
        language: {
            "url": vURL+"/js/general/datatables/"+current_lang+".json"
        },
        processing: true,
        serverSide: false,
        responsive: true,
        "destroy": true,
        "ajax": {
            "url": vURL+"/invoicing/contract/search",
            "type": 'POST',
            "data": postData
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'project_name', name: 'project_name'},
            {data: 'client_name', name: 'client_name'},
            {data: 'name', name: 'name'},
            {data: 'initial_date', name: 'initial_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'year', name: 'year'},
            {data: 'options', name: 'options'}
        ],
        dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
            }
            ],
        pageLength: 8,
    });
}

function getFormFields() {
    id_project = $('#id_project').val();
    year = $('#year').val();
    id_client = $('#id_client').val();

    var domData = {
        'id_project' : id_project,
        'year' : year,
        'id_client' : id_client,
    };

    return domData;
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
}

function validateForm(id,rules,custom_messages){

    if(id==undefined || $(id).length == 0 ){
      return false;
    }else{
        rules = (rules == undefined) ? [] : rules;
        custom_messages = (custom_messages == undefined) ? [] : custom_messages;

        jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }
            return isNaN(value) && isNaN($(params).val())
                || (Number(value) > Number($(params).val()));
        },$('#msg-final-date-greater').val());

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

        if($("#end_date").length>0){
            $("#end_date").rules('add',
                { greaterThan: "#initial_date"
            });
        }
    }
}
