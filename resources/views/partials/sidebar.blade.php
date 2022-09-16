
<aside class="main-sidebar elevation-4" style="background-color: #ebebeb;">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('image/logo.jpg') }}" alt="Kluane" class="brand-image img-circle elevation-3"
            style="opacity: .8;border-radius: 50px;">
        <span class="brand-text font-weight-light"> <b>Kluane</b></span>
        <hr>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src=" {{ asset('dist/img/user3-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{-- route('anfitriones.perfil') --}}" class="d-block"
                    class="d-block">{{-- Auth::user()->name --}} USUARIO</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('Administrador')
                    <li class='nav-item has-treeview {{ $EsMenuActivo == 'Administrador' ? 'menu-open' : '' }}'><a href='#'
                            class='nav-link  {{ $EsMenuActivo == 'Administrador' ? 'active' : '' }}'><i class="icofont-lock"></i>
                            <p>{!! trans('partials/sidebar.Administrador') !!} <i class='right fas fa-angle-left'></i></p>
                        </a>
                        <ul class='nav nav-treeview'>
                            @can('Administrador_usuarios_ver')<li class='nav-item'><a href='{{-- route('usuarios.index') --}}'
                                        class='nav-link {{ $EsSubmenuActivo == 'Usuarios' ? 'active' : '' }}'><i class="icofont-users-alt-3"></i>
                                        <p><b><font size="2">{!! trans('partials/sidebar.Usuarios') !!}</font></b> </p>
                                    </a></li>
                            <!--fin level 2--endcan-->@endcan
                            @can('Administrador_roles')<li class='nav-item'><a href='{{-- route('roles.index') --}}'
                                        class='nav-link {{ $EsSubmenuActivo == 'Roles' ? 'active' : '' }}'><i class="icofont-users-alt-4"></i>
                                        <p><b><font size="2">{!! trans('partials/sidebar.Roles') !!}</font></b></p>
                                    </a></li>
                            <!--fin level 2--endcan-->@endcan
                        </ul>
                    </li>
                @endcan




            </ul>
        </nav>


        <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
</aside>
