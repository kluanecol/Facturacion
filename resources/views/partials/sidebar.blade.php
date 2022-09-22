
<aside class="main-sidebar elevation-4 sidebar-dark-blue">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('image/logo.jpg') }}" alt="Kluane" class="brand-image img-circle elevation-3"
            style="opacity: .8;border-radius: 50px;">
        <span class="brand-text font-weight-light"> <b>Kluane</b></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src=" {{ asset('dist/img/user3-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{-- route('anfitriones.perfil') --}}" class="d-block"
                    class="d-block">{{isset(Auth::user()->name) ? Auth::user()->name : 'USUARIO'}} </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class='nav-item has-treeview '><a href='#'
                    class='nav-link active sidebar-dark-blue'><i class="icofont-document-folder"></i>
                    <p>{!! trans('menu\titles.contratos') !!}  <i class='right fas fa-angle-left'></i></p>
                    </a>
                    <ul class='nav nav-treeview'>
                       <li class='nav-item'><a href='{{ route('contracts.index')}}'
                                    class='nav-link'><i class="icofont-info"></i>
                                    <p><b><font size="2">{!! trans('menu\titles.gestion') !!}</font></b> </p>
                                </a></li>
                        <!--fin level 2--endcan-->
                        <li class='nav-item'><a href='{{-- route('roles.index') --}}'
                                    class='nav-link'><i class="icofont-gear"></i>
                                    <p><b><font size="2">{!! trans('menu\titles.configuracion') !!}</font></b></p>
                                </a></li>
                        <!--fin level 2--endcan-->
                    </ul>
                </li>
            </ul>
        </nav>


        <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
</aside>
