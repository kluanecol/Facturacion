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

        @if (config('locale.status') && count(config('locale.languages')) > 1)
            <li class="nav-item">
                @foreach (array_keys(config('locale.languages')) as $lang)
                    @if ($lang != App::getLocale())
                        @if (isset($inactive))
                            <b><a class="nav-link" href="{!! route('lang.swap', $lang) !!}"
                                    style="  pointer-events: none;">
                                    [ {!! $lang !!} ]
                                </a></b>
                        @else
                            <b><a class="nav-link" href="{!! route('lang.swap', $lang) !!}">
                                    [ {!! $lang !!} ]
                                </a></b>
                                <input type="hidden" name="current_lang" id="current_lang" value="{{$lang}}">
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

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <b><i class="fas fa-user-circle"></i></b>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    <i class="fas fa-user-alt"></i>
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
                        class="fas fa-power-off"></i>
                    {!! trans('buttons.cerrarCesion') !!}
                </a>

                <form id="logout-form" action="{{ route('log_out') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="dropdown-divider"></div>
            </div>
        </li>

    </ul>
</nav>
