<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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
    <link rel="stylesheet"
        href=" {{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">
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

    <link rel="stylesheet" href="{{ asset('dist/css/select2-bootstrap.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

    <link href=" {{ asset('icofont/icofont.min.css') }}" rel="stylesheet">

    <link href="{{ asset('bower_components/jquery-loading/dist/jquery.loading.css') }}" rel="stylesheet">
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
        .dataTables_scroll {
            overflow-x: scroll;
        }

        .btn-primary:not(:disabled):not(.disabled).active,
        .btn-fruit:not(:disabled):not(.disabled):active,
        .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #275FA9;
            border-color: #275FA9;
        }

        .btn-primary {
            color: #fff;
            background-color: #275FA9;
            border-color: #275FA9;
        }

        .dropdown-item:active {
            color: #fff;
            background-color: #275FA9;
        }

        .main-sidebar,
        .main-sidebar::before {
            transition: margin-left .3s ease-in-out, width .3s ease-in-out;
        }

        body:not(.sidebar-mini-md) .content-wrapper,
        body:not(.sidebar-mini-md) .main-footer,
        body:not(.sidebar-mini-md) .main-header {
            transition: margin-left .3s ease-in-out;
        }

        td {
            font-family: Arial, Verdana;
            font-size: 12px;
        }

        th {
            font-family: Arial, Verdana;
            font-size: 12px;
        }

        .sidebar-dark-blue {
            background: #003366 !important;
        }

        body {
            overflow-x: scroll;
            color: #515151;
        }



        .table-responsive::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .table-responsive::-webkit-scrollbar:vertical {
            width: 10px;
        }

        .table-responsive::-webkit-scrollbar-button:increment,
        .chatlist-body::-webkit-scrollbar-button {
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

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed body">


    @include('partials.navbar')
    @include('partials.sidebar')

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
            #fondo {
                background: url({{ asset('img/LoginBackgroud.png') }}) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            .clase_cargando {
                position: fixed;
                top: 0px;
                left: 0px;
                width: 100%;
                background-color: #FFFFFF80;
            }
        </style>

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ Session::get('success') }}
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
            @yield('content')
        </section>

        @include('partials.footer')

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
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src=" {{ asset('dist/js/demo.js') }}"></script>
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
    <script src="{{ asset('bower_components/jquery-loading/dist/jquery.loading.min.js') }}" type="text/javascript">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            Swal.fire({
                title: '<strong>Kluane Facturación</strong>',
                type: 'info',
                html:
                    '',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Genial!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                    '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var height = $(window).height();
            $('#capa_cargando').height(height);


            $('form').each(function() {
                $(this).submit(function(event) {
                    bloquearPagina();
                });
            });

        });


        $(function() {

            $('.select2').select2();

            $('.select2A').select2();




        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

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

    @yield('scripts')

</body>

</html>
