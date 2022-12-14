@extends('layouts.master_panel')
@section('title', trans('titles.parametricas'))
@section('card-icon')<i class="icofont-document-folder"></i>@endsection
@section('card-title', strtoupper(trans('titles.parametricas')))

 <!-- DatePicker -->
 <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Custom Styles -->
<link href="{{ asset('bower_components/toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/general_tooltip.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href=" {{ asset('css/general.css') }}" type="text/css">
@section('content')

    <div class="col-md-12" id="main-url" data-url="{{URL::to('/')}}">
        @include('sections.validation.messages')
        @include('sections.parametrics.components.messages')
        <div class="row">
            <div class="col-md-12">

                <div class="row mb-2">
                    @include('sections.parametrics.form.filters')
                </div>
            </div><hr>
        </div>

        <div class="row">
            <div id="div-btn-add-contract" class="col-md-12 mb-2">
                <div class="btn-group-vertical" role="group">
                    <button type="button" class="btn btn-primary btn-block add-parametric">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>  {!! trans('buttons.nuevo') !!}
                    </button>
                    <br>
                </div>
            </div>
            <div class="col-md-12">
                @include('sections.parametrics.tables.filtered_parametrics')
            </div>
        </div>
    </div>


@endsection

@push('plugins')

    <script src=" {{ asset('plugins/jquery/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('js/parametrics/parametric.js?v=2022-12-08') }}" type="text/javascript"></script>

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
