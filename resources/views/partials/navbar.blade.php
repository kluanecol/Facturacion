<nav class="main-header navbar navbar-expand navbar-white navbar-light"
    style="border-bottom:0px solid gray;box-shadow:0px 0px 5px rgba(0,0,0,0.5);">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

    </ul>



    <!--Right navbar links -->
    <ul class="navbar-nav ml-auto">




        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <b>{{-- Auth::user()->name --}}</b>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    <a href="{{-- route('anfitriones.perfil') --}}" class="d-block">
                        {!! trans('partials/navbar.Opciones') !!} <i class="fa fa-gears"></i>
                    </a>
                </span>
                <div class="dropdown-divider"></div>
                <span class="dropdown-item dropdown-header">

                </span>
                <div class="dropdown-divider"></div>
                <span class="dropdown-item dropdown-header">

                </span>

                <a class="btn btn-primary btn-block" href="{{ route('log_out') }}"
                    onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();"><i
                        class="fas fa-arrow-right"></i>
                    {!! trans('partials/navbar.Salir') !!}
                </a>
                <!--Comprobamos si el status esta a true y existe más de un lenguaje-->

                <form id="logout-form" action="{{ route('log_out') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="dropdown-divider"></div>
            </div>
        </li>
        @if (config('locale.status') && count(config('locale.languages')) > 1)
            <li class="nav-item">
                @foreach (array_keys(config('locale.languages')) as $lang)
                    @if ($lang != App::getLocale())
                        @if (isset($inactive))
                            <b><a class="nav-link" href="{!! route('lang.swap', $lang) !!}" title="Cambiar de idioma"
                                    style="  pointer-events: none;">
                                    [ {!! $lang !!} ]
                                </a></b>
                        @else
                            <b><a class="nav-link" href="{!! route('lang.swap', $lang) !!}" title="Cambiar de idioma">
                                    [ {!! $lang !!} ]
                                </a></b>
                        @endif
                    @endif
                @endforeach
            </li>
        @endif

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if (Session::get('country') != null)
                    <b>{{ Session::get('country')->name }}</b>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if (Session::get('countries') != null)
                    @foreach (Session::get('countries') as $country)
                        <a class="btn btn-primary btn-block" href="{!! route('lang.swapcountry', $country->id) !!}">
                            {{ $country->name }}
                        </a>
                    @endforeach
                @endif
            </div>

        </li>
    </ul>
</nav>
