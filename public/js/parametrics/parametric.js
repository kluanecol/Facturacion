

var vURL = null;
var vURL_INVOICING = null;
let table_parametrics = 0;
let id_country = null;
let id_parametrics = [];

jQuery(function() {

	vURL = $('#main-url').data('url');
    vURL_INVOICING = $('#main-url-init').data('url');

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

    $(document).on('click','#search-parametrics',function(){
        domData = getFormFields();

        if (id_country != '' && id_parametrics != '') {
            refreshParametricsTable(domData);
        }else{
            Swal.fire({
                type: 'warning',
                title: $('#msg-cant-filter-title').val()+'!',
                text: $('#msg-cant-filter-subtitle').val()
            });
        }
    });

    $(document).on('click','.add-parametric',function(){
        getParametricForm();
    });

    $(document).on('click','#btn-add',function(){

        if ($("#form-parametric").valid()) {
            saveParametric('form-parametric');
        }

    });

    $(document).on('click','#btn-create-new-charge',function(){
        getOtherChargeForm();
    });

    $(document).on('click','#btn-save-parametric',function(){

        if ($('#form-other-charge').valid()) {
            saveParametric('form-other-charge');
        }
    });

    $(document).on('click','.edit-parametric',function(){
        getParametricForm($(this).data('id'));
    });

    $(document).on('click','.disable-parametric',function(){
        disableParametric($(this).data('id'));
    });
});

function getParametricForm(id_parametric = null){

    var domData = {
        id_parametric : id_parametric
    }

    $.post(
        vURL+"/invoicing/parametric/getParametricForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-parametric-form-title').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                  })

                refreshInputs();
                validateForm("#form-parametric",[],[]);
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

function getOtherChargeForm(){
    $('body').loading({
        message: $('#msg-loading').val()
    });

    var domData = {

    }

    $.post(
        vURL+"/invoicing/parametric/getOtherChargeForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>'+$('#msg-parametric-config-other-charge').val()+'</strong>',
                    html:data.html,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: true
                })

                $('body').loading('stop');
                validateForm("#form-other-charge",[],[]);
                $("select.selectpicker").selectpicker('refresh');
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

function saveParametric(form_name) {

    let myForm = document.getElementById(form_name);
    var domData = new FormData(myForm);

    $('body').loading({
      message: $('#msg-loading').val()
    });

    $.ajax({

        url: vURL+'/invoicing/parametric/save',
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
                    timer: 1500
                });

                table_parametrics.ajax.reload();
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

function disableParametric(id_parametric) {

    var formData = new FormData();
    formData.append("id_parametric", id_parametric);

    Swal.fire({
        title: $('#msg-parametrics-delete').val(),
        type: 'question',
        showCancelButton: true,
        confirmButtonText: $('#msg-change-state').val(),
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

                url: vURL+'/invoicing/parametric/changeState',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    $('body').loading('stop');

                    if (data.status == 200) {
                        toastr.success(data.message, data.title);

                        table_parametrics.ajax.reload();

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

function refreshParametricsTable(datos) {
    table_parametrics = $('#table-parametrics').DataTable({
        language: {
            "url": vURL+"/js/general/datatables/"+current_lang+".json"
        },
        processing: true,
        serverSide: false,
        "destroy": true,
        "ajax": {
            "url": vURL+"/invoicing/parametric/search",
            "type": 'POST',
            "data": datos
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'country', name: 'country'},
            {data: 'name', name: 'name'},
            {data: 'state', name: 'state'},
            {data: 'auxiliary', name: 'auxiliary'},
            {data: 'parent', name: 'parent'},
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
    id_country = $('#id_country').val();
    id_parametrics = $('#id_parent_parametrics').val();


    var domData = {
        'id_country' : id_country,
        'id_parametrics' : id_parametrics
    };

    return domData;
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

