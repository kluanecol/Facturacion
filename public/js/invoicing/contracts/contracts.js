

var vURL = null;
var selectedData = null;
let table_contracts= null;
let id_project = null;
let year = null;
let periodo = null;
let informes_seleccionados = [];

jQuery(function() {
	vURL = $('#main-url').data('url');

    $(document).on('click','#search-contracts',function(){
        id_project = $('#id_project').val();
        year = $('#year').val();

        var datos = {
            'id_project' : id_project,
            'year' : year,
        }

        if (id_project != '' && year != '') {
            refreshContractsTable(datos);
        }else{
            Swal.fire({
                type: 'warning',
                title: $('#msj-cant-filter-title').val()+'!',
                text: $('#msj-cant-filter-subtitle').val()
            });
        }
    });

    $(document).on('click','.add-contract',function(){
        getContractForm();
    });

    $(document).on('click','#btn-add',function(){


        $("#form-contract").valid();
    });






});

function getContractForm(){

    var datos = {}

    $.post(
        vURL+"/invoicing/contracts/getContractForm",
        datos,
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

                actualizarInputs();
                validarForm("#form-contract",[],[]);

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


function refreshContractsTable(datos) {
    table_contracts = $('#table-contracts').DataTable({
        processing: true,
        serverSide: false,
        responsive: false,
        "destroy": true,
        scrollX: 400,
        scrollY: 380,
        scrollCollapse: true,
        language: {
            "sProcessing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> <span class="sr-only">Procesando...</span>',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "ajax": {
            "url": vURL+"/invoicing/contracts/search",
            "type": 'POST',
            "data": datos
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'project_name', name: 'project_name'},
            {data: 'initial_date', name: 'initial_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'year', name: 'year'},
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

function actualizarInputs(){
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

function validarForm(id,rules,messages){
    /* JQUERY VALIDATE*/
    if(id==undefined || $(id).length == 0 ){
      return false;
    }else{
        rules = (rules == undefined) ? [] : rules;
        messages = (messages == undefined) ? [] : messages;

        messages =  {
            end_date: {
                greaterThan: "La fecha final debe ser mayor a la inicial."
            }
        };
        $(id).validate().destroy();

        $.validator.addClassRules("vc_max", {
            maxlength: 25
        });

        jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val())
                || (Number(value) > Number($(params).val()));
        },'Must be greater than {0}.');

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
