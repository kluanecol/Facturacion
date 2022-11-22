@extends('layouts.master_panel')
@section('title', trans('titles.facturacion'))
@section('card-icon')<i class="icofont-options"></i>@endsection
@section('card-title', strtoupper(trans('titles.facturacion')))

 <!-- DatePicker -->
 <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Modal Styles -->
<link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('bower_components/toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/configuration_collapse.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/card.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/range_picker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/radio_switch.css') }}" rel="stylesheet" type="text/css" />

@section('content')
    <div class="col-md-12" id="main-url" data-url="{{URL::to('/')}}">
        <div id="main-url-init" data-url="{{URL::to('/invoicing')}}"></div>
        @include('sections.validation.messages')
        @include('sections.invoices.components.messages')
        <div class="row">

            {!! Form::hidden('id_contract', (isset($contract) ? $contract->id : null), ['id'=>'id_contract']) !!}

            <div class="col-md-12">
                <div class="row mb-2">
                    @include('sections.contracts.components.contract-card')
                </div>
            </div>
            <hr>
        </div>

        <div class="row">
            <div id="div-btn-add-invoice" class="col-md-12 mb-2">
                <div class="btn-group-vertical" role="group">
                    <button type="button" class="btn btn-primary btn-block add-invoice">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>  {!! trans('buttons.nuevo') !!}
                    </button>
                    <br>
                </div>
            </div>
            <div class="col-md-12">
                @include('sections.invoices.tables.filtered_invoices')
            </div>
        </div>

    </div>


@endsection

@push('plugins')
    <script src=" {{ asset('plugins/jquery/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('js/invoicing/invoices/invoices.js?v=2022-11-20') }}" type="text/javascript"></script>

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
@endpush
