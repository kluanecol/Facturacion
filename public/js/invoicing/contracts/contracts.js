

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
        year = $('year').val();

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
            })
        }
    });

    $(document).on('click','.agregar-lote-pago',function(){
        obtenerFormLotePago();
    });

    $(document).on('click','#btn-buscar-informes',function(){
        informes_seleccionados = [];
        var fecha_inicio = $('#dt_fecha_inicio').val();
        var fecha_fin  = $('#dt_fecha_fin').val();
        var id_area = $('#i_fk_id_area').val();

        if (fecha_inicio == '' || fecha_fin == '') {
            swal({
                title: `Selecciones las fechas`,
                html: `Por favor seleccione un rango de fechas para filtrar los informes de pago`,
                type: `warning`,
                showConfirmButton: false,
                timer: 3000
            })
        }
        else if(id_area == ''){
            swal({
                title: `¡No hay un área seleccionada!`,
                html: `Por favor seleccione un área para filtrar los informes de pago`,
                type: `warning`,
                showConfirmButton: false,
                timer: 3000
            })
        }else{

            var datos = {
                'dt_fecha_inicio' : fecha_inicio,
                'dt_fecha_fin' : fecha_fin,
                'i_area' : id_area,
            }

            refreshContractsTable(datos);
        }


    });

    $(document).on('change', '.check_informe', function(e){
        var row = $(this).closest('tr');

        if(this.checked)
        {
          informes_seleccionados.push($(this).val());
          row.addClass('selected');
        } else {
            if(informes_seleccionados.includes($(this).val())){
                informes_seleccionados.splice(informes_seleccionados.indexOf($(this).val()), 1);
                ;
            }
          row.removeClass('selected');
        }
        $('#form-lote-pago input[name="informes"]').val(informes_seleccionados);
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    $(document).on('click', '#btn-enviar', function(e){
        e.preventDefault();

        var anexo = $('input[name="file_anexo_radicado"]').val();
        var allowedExtensions = /(.pdf)$/i;
        var validaRadicado = /^202[0-9]{1}(IE|EE)[0-9]{4,5}$/i;

        if (!$('#form-lote-pago').valid()) {

            swal({
                title: `¡Campos Sin Diligenciar!`,
                html: `Por favor rellene todos los campos, y seleccione mínimo un informe de pago`,
                type: `warning`,
                showConfirmButton: false,
                timer: 3000
            });
        }
        else if ($('#informes').val() == []) {
            swal({
                title: `¡No Hay Informes de Pago Seleccionados!`,
                html: `Por favor seleccione almenos uno`,
                type: `warning`,
                showConfirmButton: false,
                timer: 3000
            });
        }else if (informes_seleccionados.length > 20) {
                swal({
                    title: `¡Superó el límite de informes que puede enviar en un lote!`,
                    html: `Máximo 20, tiene seleccionados: `+informes_seleccionados.length,
                    type: `warning`,
                    showConfirmButton: false,
                    timer: 3000
                });
        }else if(anexo == ''){
            swal({
                title: `¡No está cargado el archivo anexo!`,
                html: `Por favor suba un archivo`,
                type: `warning`,
                showConfirmButton: false,
                timer: 3000
            });
        }
        else if(!allowedExtensions.exec(anexo)){
            swal({
                title: `¡El archivo no es de un formato válido!`,
                html: `Por favor suba un archivo en formato .PDF`,
                type: `warning`,
                showConfirmButton: false,
                timer: 5000
            });
        }
        else if(!validaRadicado.test($("#vc_radicado").val())){
            swal({
                title: `¡El radicado de CORDIS no tiene un formato válido!`,
                html: `Por favor digite el radicado con formato AAAA[IE][XXXXX]`,
                type: `warning`,
                showConfirmButton: false,
                timer: 5000
            });
        }
        else{

            var datos = {
                informes : $('#informes').val()
            }
            $('#modalLotePago').loading({
                message: 'Procesando...'
              });
            $.post(
                vURL+"/postcontractual/pagolote/obtenerInformesLote",
                datos,
                function(data)
                {
                    $('#modalLotePago').loading('stop');
                    if (data.success) {
                        swal({
                            title: '¿Está seguro de enviar el lote de pagos?',
                            html: data.html,
                            type: 'question',
                            showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, Enviar',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if(result.value==true){

                                enviarLote();
                            }
                        });

                    } else {
                        swal({
                            title: 'Algo salió mal!',
                            html: 'Vuelve a intentar el envío del lote de pagos',
                            type: 'warning',
                            //position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            ).fail(function(data) {
                if(data.status == 419){
                  swal({
                    title: `¡Algo salió Mal!`,
                    html: `Ha caducado el tiempo de sesión, se recargará la página`,
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                  }).then(()=>{
                    location.reload();
                  });

                }else if(data.status == 500){
                  swal({
                    title: `¡Algo salió Mal!`,
                    html: `Ha ocurrido un error en el servidor, contacte al soporte de Pandora`,
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                  })
                }
            });


        }
   });

   $(document).on('click', '.ver_informes_lote', function(e){

        var datos = {
            id_lote : $(this).data('id')
        }

        $('body').loading({
            message: 'Procesando...'
          });
        $.post(
            vURL+"/postcontractual/pagolote/obtenerInformesLoteEnviado",
            datos,
            function(data)
            {
                $('body').loading('stop');
                if (data.success) {
                    swal({
                        title: 'Informes enviados en el lote de pagos',
                        html: data.html,
                        type: 'info',
                        showCloseButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                    });

                } else {
                    swal({
                        title: 'Algo salió mal!',
                        html: 'Vuelve a intentar el envío del lote de pagos',
                        type: 'warning',
                        //position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        ).fail(function(data) {
            if(data.status == 419){
              swal({
                title: `¡Algo salió Mal!`,
                html: `Ha caducado el tiempo de sesión, se recargará la página`,
                type: `error`,
                showConfirmButton: false,
                timer: 3000
              }).then(()=>{
                location.reload();
              });

            }else if(data.status == 500){
              swal({
                title: `¡Algo salió Mal!`,
                html: `Ha ocurrido un error en el servidor, contacte al soporte de Pandora`,
                type: `error`,
                showConfirmButton: false,
                timer: 3000
              })
            }
        });

    });

});

function obtenerFormLotePago(){

    var datos = {}

    $.post(
        vURL+"/postcontractual/pagolote/obtenerFormLotePago",
        datos,
        function(data)
        {
            if (data.success) {
                $("#modalLotePago").modal("show");
                $("#contenedor-form-lote-pago").html(data.html);
                actualizarInputs();
                validarForm("#form-lote-pago",[],[]);

            } else {
                swal({
                    title: 'Algo salió mal!',
                    html: 'Se presentaron errores en la consulta de los procedimientos',
                    type: 'error',
                    //position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    ).fail(function(data) {
        if(data.status == 419){
          swal({
            title: `¡Algo salió Mal!`,
            html: `Ha caducado el tiempo de sesión, se recargará la página`,
            type: `error`,
            showConfirmButton: false,
            timer: 3000
          }).then(()=>{
            location.reload();
          });

        }else if(data.status == 500){
          swal({
            title: `¡Algo salió Mal!`,
            html: `Ha ocurrido un error en el servidor, contacte al soporte de Pandora`,
            type: `error`,
            showConfirmButton: false,
            timer: 3000
          })
        }
    });
}

function enviarLote() {

    let myForm = document.getElementById('form-lote-pago');
    var datos = new FormData(myForm);

    $('#modalLotePago').loading({
      message: 'Se está enviando el lote de pagos...'
    });

    $('#btn-enviar').prop('disabled', true);


    $.ajax({

        url: vURL+'/postcontractual/pagolote/enviarLotePago',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: datos,
        success: function(data){
          $('#modalLotePago').loading('stop');
          $("#modalLotePago").modal('hide');
          $('#btn-enviar').prop('disabled', false);

          if (data.type == 'success') {
            swal({
                title: data.title,
                html: data.message,
                type: data.type,
                showConfirmButton: true,
              });
          }else{
            swal({
              title: data.title,
              html: data.message,
              type: data.type,
              position: 'bottom-end',
              showConfirmButton: false,
              timer: 3000
            });
          }
        },
        error: function(data){
            $('#modalLotePago').loading('stop');

            if(data.status == 419){
                swal({
                  title: `¡Algo salió Mal!`,
                  html: `Ha caducado el tiempo de sesión, se recargará la página`,
                  type: `error`,
                  showConfirmButton: false,
                  timer: 3000
                }).then(()=>{
                  location.reload();
                });
            }else if(data.status == 500){
                swal({
                    title: `¡Algo salió Mal!`,
                    html: `Ha ocurrido un error en el servidor, contacte al soporte de Pandora`,
                    type: `error`,
                    showConfirmButton: false,
                    timer: 3000
                });
                //location.reload();
            }
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
            {data: 'i_pk_id', name: 'i_pk_id'},
            {data: 'vc_usuario', name: 'vc_usuario'},
            {data: 'vc_radicado', name: 'vc_radicado'},
            {data: 'dt_fecha', name: 'dt_fecha'},
            {data: 'vc_area', name: 'vc_area'},
        ],
        dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
                title: 'Consulta Lotes de Pago - Pandora'
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

    $(".btn-switch").bootstrapSwitch({
        onInit: function() {
            var valor = $(this).is(":checked") ? 1 : 0;
            $(this).val(valor);
        },
        onSwitchChange: function() {
            var valor = $(this).is(":checked") ? 1 : 0;
            $(this).val(valor);
        }
    });

    $(":file").filestyle({
        input: true,
        placeholder: "Sin archivo",
        buttonBefore: true,
        htmlIcon: '<i class="fa fa-cloud-upload" aria-hidden="true"></i>',
        text: ""
    });

    $('[data-toggle="tooltip"]').tooltip();
}

function validarForm(id,reglas,mensajes){
    /* JQUERY VALIDATE*/
    if(id==undefined || $(id).length == 0 ){
      return false;
    }else{
        reglas = (reglas == undefined) ? [] : reglas;
        mensajes = (mensajes == undefined) ? [] : mensajes;
        $(id).validate().destroy();
        $.validator.addClassRules("obligatorio", {
            required: true
        });

        $.validator.addClassRules("vc_max", {
            maxlength: 25
          });

        $(id).validate({
        //ignore: [],
        rules: reglas,
        messages: mensajes,
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
