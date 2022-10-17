@extends('layouts.master_panel')
@section('title', trans('menu\titles.configuracion'))
@section('card-icon')<i class="icofont-options"></i>@endsection
@section('card-title', strtoupper(trans('menu\titles.configuracion')))

 <!-- DatePicker -->
 <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Modal Styles -->
<link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('bower_components/toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/configuration_collapse.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/card.css') }}" rel="stylesheet" type="text/css" />

@section('content')

    <div class="col-md-12" id="main-url" data-url="{{URL::to('/')}}">
        @include('sections.validation.messages')
        @include('sections.contracts.components.messages')
        <div class="row">
            <div class="col-md-12">

                <div class="row mb-2">
                    @include('sections.contracts.components.contract-card')

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach ($configurationSubtypes as $configuration)
                                        @include('sections.contracts.configurations.components.configuration-subtype',['configuration' => $configuration])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>

    </div>


@endsection

@push('plugins')

    <script src=" {{ asset('plugins/jquery/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('js/invoicing/configurationSubtypes/configurationSubtypes.js?v=2022-10-14') }}" type="text/javascript"></script>

    <!-- DataTables -->
    <script src=" {{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/dataTables.buttons.min.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/buttons.flash.min.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/jszip.min.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/vfs_fonts.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/buttons.html5.min.js') }}"></script>
    <script src=" {{ asset('plugins/datatables-bs4/js/buttons.print.min.js') }}"></script>

    <script src="{{ asset('bower_components/jquery-loading/dist/jquery.loading.min.js') }}" type="text/javascript">
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    </script>
@endpush
