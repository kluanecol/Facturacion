

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

    $.post(
        vURL+"/invoicing/contracts/getContractForm",
        domData,
        function(data)
        {
            if (data.success) {
                Swal.fire({
                    width:'800px',
                    title: '<strong>Gestión de contrato</strong>',
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
                    title: 'Algo salió mal!',
                    text: 'Ocurrió un error al obtener los datos',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    ).fail(function(data) {
        if(data.status == 419){
            Swal.fire({
                type: 'error',
                title: 'Algo salió mal!',
                text: '`Ha caducado el tiempo de sesión, se recargará la páginas',
                showConfirmButton: false,
                timer: 2000
            }).then(()=>{
                location.reload();
            });

        }else if(data.status == 500){
            Swal.fire({
                type: 'error',
                title: 'Algo salió mal!',
                text: 'Ha ocurrido un error en el servidor, contacte al soporte',
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
      message: 'Procesando...'
    });

    $.ajax({

        url: vURL+'/invoicing/contracts/save',
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
                refreshContractsTable(domData);

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
                  title: `¡Algo salió Mal!`,
                  html: `Ha caducado el tiempo de sesión, se recargará la página`,
                  type: `error`,
                  showConfirmButton: false,
                  timer: 3000
                }).then(()=>{
                  location.reload();
                });
            }else if(data.status == 500){
                Swal.fire({
                    title: `¡Algo salió Mal!`,
                    html: `Ha ocurrido un error en el servidor, contacte al equipo de soporte`,
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
        title: '¿Seguro que desea eliminar el contrato?',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: `Cancelar`,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value == true) {
            $('body').loading({
                message: 'Procesando...'
            });

            $.ajax({

                url: vURL+'/invoicing/contracts/delete',
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
                            title: `¡Algo salió Mal!`,
                            html: `Ha caducado el tiempo de sesión, se recargará la página`,
                            type: `error`,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(()=>{
                            location.reload();
                        });
                    }else if(data.status == 500){
                        Swal.fire({
                            title: `¡Algo salió Mal!`,
                            html: `Ha ocurrido un error en el servidor, contacte al equipo de soporte`,
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


function refreshContractsTable(datos) {
    table_contracts = $('#table-contracts').DataTable({
        language: {
            "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        },
        processing: true,
        serverSide: false,
        responsive: false,
        "destroy": true,
        scrollX: 400,
        scrollY: 380,
        scrollCollapse: true,

        "ajax": {
            "url": vURL+"/invoicing/contracts/search",
            "type": 'POST',
            "data": datos
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'project_name', name: 'project_name'},
            {data: 'client_name', name: 'client_name'},
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

function validateForm(id,rules,messages){
    /* JQUERY VALIDATE*/
    if(id==undefined || $(id).length == 0 ){
      return false;
    }else{
        rules = (rules == undefined) ? [] : rules;
        messages = (messages == undefined) ? [] : messages;

        jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }
            return isNaN(value) && isNaN($(params).val())
                || (Number(value) > Number($(params).val()));
        },'Must be greater than {0}.');

        messages =  {
            id_project: {
                required: "Es obligatorio"
            },
            initial_date: {
                greaterThan: "La fecha final debe ser mayor a la inicial."
            },
            end_date: {
                greaterThan: "La fecha final debe ser mayor a la inicial.",
                required: "fecha obligatoria"
            }

        };

        $(id).validate().destroy();

        $.validator.addClassRules("vc_max", {
            maxlength: 25
        });

        $(id).validate({
            //ignore: [],
            rules: rules,
            messages: messages,
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
