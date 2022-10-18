

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
        getConfigurationForm($(this).data('id'));
    });

    $(document).on('click','#btn-save-configuration',function(){

        if ($('#form-configuration').valid()) {
            saveConfiguration();
        }

    });

    $(document).on('click','.edit-contract',function(){
        getContractForm($(this).data('id'));
    });

    $(document).on('click','.delete-contract',function(){
        deleteContract($(this).data('id'));
    });


});

function getConfigurationForm(id_configuration){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {
        id_configuration : id_configuration,
        id_contract : $('#id_contract').val()
    }

    $.post(
        vURL+"/invoicing/configurationSubtype/getForm",
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

function refreshInputs(){
    informes_seleccionados = [];
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
