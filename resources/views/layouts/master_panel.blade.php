<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RHOMB | @yield('title')</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('image/favicon.ico') }}" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href=" {{ asset('plugins/fontawesome-free/css/all.min.css') }} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href=" {{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">
  <!-- iCheck -->
  <link rel="stylesheet" href=" {{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }} ">
  <!-- JQVMap -->
  <link rel="stylesheet" href=" {{ asset('plugins/jqvmap/jqvmap.min.css') }} ">
  <!-- Theme style -->
  <link rel="stylesheet" href=" {{ asset('dist/css/adminlte.min.css') }} ">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href=" {{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">
  <!-- Daterange picker -->
  <link rel="stylesheet" href=" {{ asset('plugins/daterangepicker/daterangepicker.css') }} ">
  <!-- summernote -->
  <link rel="stylesheet" href=" {{ asset('plugins/summernote/summernote-bs4.css') }} ">

  <link rel="stylesheet" href="{{ asset("dist/css/select2-bootstrap.css")}}">

  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

  <link href=" {{ asset("icofont/icofont.min.css")}}" rel="stylesheet">


  <!-- DataTables -->
  <link rel="stylesheet" href=" {{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href=" {{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!--link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/-->

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href=" {{ asset('css/admin_panel.css') }}">

  <style type="text/css">

    .dataTables_scroll
    {
        overflow-x: scroll;
    }

    #example_extra{
        width: 100% !important;
    }

    #example1{
        width: 100% !important;
        overflow:auto;
    }



    .btn-primary:not(:disabled):not(.disabled).active, .btn-fruit:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle{
        color: #fff;
        background-color: #275FA9 ;
        border-color: #275FA9 ;
    }

    .btn-primary{
        color: #fff;
        background-color: #275FA9 ;
        border-color: #275FA9 ;
    }

    .dropdown-item:active{
        color: #fff;
        background-color: #275FA9 ;
    }

    .main-sidebar, .main-sidebar::before {
    transition: margin-left .3s ease-in-out,width .3s ease-in-out;
     }

      body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
          transition: margin-left .3s ease-in-out;
      }
    td{
    font-family: Arial, Verdana;
    font-size:12px;
    }
    th{
        font-family: Arial, Verdana;
        font-size:12px;
    }
    .sidebar-dark-blue{
    background: #003366 !important;
  }
  body{
    overflow-x: scroll;
    color: #515151;
  }



  .table-responsive::-webkit-scrollbar {
    -webkit-appearance: none;
}

.table-responsive::-webkit-scrollbar:vertical {
    width:10px;
}

.table-responsive::-webkit-scrollbar-button:increment,.chatlist-body::-webkit-scrollbar-button {
    display: none;
}

.table-responsive::-webkit-scrollbar:horizontal {
    height: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background-color: #275FA9;
    border-radius: 10px;
    /*border: 2px solid #f1f2f3;*/
}

.table-responsive::-webkit-scrollbar-track {
    border-radius: 10px;
}


  </style>

  @yield("css")
</head>
<body class="hold-transition sidebar-mini layout-fixed body"  onLoad="habilitarPagina();">


@include("partials.navbar")
@include("partials.sidebar")

<div class="content-wrapper" id="fondo">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"></h1>
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div>
  </div>
  <style>
      #fondo{
            background: url({{ asset('img/LoginBackgroud.png') }}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
      }

  .clase_cargando {
		position:fixed;
		top:0px;
		left:0px;
		width:100%;
    background-color: #FFFFFF80;
	}

  </style>

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('error')}}
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('success')}}
        </div>
    @endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif


  <section class="content">
      @yield("content")
  </section>


  <footer class="main-footer" style="width:100%; margin-left: 0px!important;background-color:#003366;color:rgba(0, 0, 0);border-top:0px solid gray;position: relative;">
    <div class="text-center">
        <p> <b>Desarrollado por <a href="http://www.sipse.com.co">SIPSE S.A.S.</a> para KLUANE| Copyright &copy; 2020 KLUANE. rhomb windows</b> </p>
    </div>
    <div class="float-right d-none d-sm-inline-block"style="margin-top:-10px;">
      <b>Versión</b> {{config('app.version')}}
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>



  <!-- jQuery -->
  <script src=" {{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src=" {{ asset('plugins/jquery-ui/jquery-ui.min.js') }} "></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src=" {{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
  <!-- ChartJS -->
  <script src=" {{ asset('plugins/chart.js/Chart.min.js') }} "></script>
  <!-- JQVMap -->
  <script src=" {{ asset('plugins/jqvmap/jquery.vmap.min.js') }} "></script>
  <script src=" {{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }} "></script>
  <!-- jQuery Knob Chart -->
  <script src=" {{ asset('plugins/jquery-knob/jquery.knob.min.js') }} "></script>
  <!-- daterangepicker -->
  <script src=" {{ asset('plugins/moment/moment.min.js') }} "></script>
  <script src=" {{ asset('plugins/daterangepicker/daterangepicker.js') }} "></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src=" {{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }} "></script>
  <!-- Summernote -->
  <script src=" {{ asset('plugins/summernote/summernote-bs4.min.js') }} "></script>
  <!-- overlayScrollbars -->
  <script src=" {{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }} "></script>
  <!-- AdminLTE App -->
  <script src=" {{ asset('dist/js/adminlte.js') }} "></script>
  <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <!-- AdminLTE for demo purposes -->
  <script src=" {{asset('dist/js/demo.js') }}"></script>
  <!-- DataTables -->

  <script src=" {{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/dataTables.buttons.min.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/buttons.flash.min.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/jszip.min.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/pdfmake.min.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/vfs_fonts.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/buttons.html5.min.js') }}"></script>
  <script src=" {{ asset('plugins/datatables-bs4/js/buttons.print.min.js') }}"></script>
<!--script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script-->

  <script type="text/javascript">

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  var height = $(window).height();
      $('#capa_cargando').height(height);


     $('form').each(function(){
       $(this).submit(function(event){
        bloquearPagina();
       });
     });

    console.log( $('form'));
  });

function habilitarPagina() {
	document.getElementById('capa_cargando').style.visibility = 'hidden';

}

function bloquearPagina() {
	document.getElementById('capa_cargando').style.visibility = 'visible';

}


  $(function () {

    $('.select2').select2();

    $('.select2A').select2();




  });

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    var table = $('#example1').DataTable( {

        responsive: true,
        "bDestroy": true,
        dom: 'Bfrtlip',
        buttons: [

                   {
            extend: 'copy',
            text: '<i class="fas fa-copy"> Copy</i>',
            className:'btn btn-outline-secondary btn-sm'
              },

                {
            extend: 'excel',
            text: '<i class="fas fa-file-excel"> Excel</i>',
            className:'btn btn-outline-secondary btn-sm'
              },
                    {
            extend: 'print',
            text: '<i class="fas fa-print"> Print</i>',
            className:'btn btn-outline-secondary btn-sm'

              },
        ],
        language: {
                decimal:        '.',
                emptyTable:     '{!! trans('layouts/master_panel.emptyTable') !!}',
                info:           '{!! trans('layouts/master_panel.info') !!}',
                infoEmpty:      '{!! trans('layouts/master_panel.Sin registros') !!}',
                infoFiltered:   '{!! trans('layouts/master_panel.infoFiltered') !!}',
                infoPostFix:    '',
                thousands:      ',',
                lengthMenu:    '{!! trans('layouts/master_panel.Mostrar _MENU_ filas') !!}',
                loadingRecords: '{!! trans('layouts/master_panel.processing') !!}',
                processing:     '{!! trans('layouts/master_panel.processing') !!}',
                search:         '{!! trans('layouts/master_panel.Buscar:') !!}',
                zeroRecords:     '{!! trans('layouts/master_panel.No se encontraron registros') !!}',
                aria: {
                    'sortAscending':  ': Ordenar ascendente',
                    'sortDescending': ': Ordenar descendente'
                },
                paginate: {
                    'first':      'Primero',
                    'last':       'Último',
                    'next':       '{!! trans('layouts/master_panel.Siguiente') !!}',
                    'previous':     '{!! trans('layouts/master_panel.Anterior') !!}',
                }
        }
    } );

    $(function() {
    $('.scroll').jscroll({
        autoTrigger: true,
        nextSelector: '.pagination li.active + li a',
        contentSelector: 'div.scroll',
        callback: function() {
            $('ul.pagination:visible:first').hide();
        }
    });
});




  </script>

  @yield("scripts")
<div id="capa_cargando" class="clase_cargando">
	<div style="position:absolute; top:250px; left:50%;">
		<img src="{{ asset('img/cargando-loading-041.gif') }}" alt="">
	</div>
</div>

</body>
</html>
