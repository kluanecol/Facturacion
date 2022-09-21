@extends('layouts.master_panel')
@section('title', trans('menu\titles.contratos'))
@section('card-icon')<i class="icofont-document-folder"></i>@endsection
@section('card-title', strtoupper(trans('menu\titles.contratos')))

@section('content')

    <a href="{{-- route('inventario.compras.index') --}}" class="btn btn-primary btn-sm float-right">{!! trans('inventarios/compras/index_ordenes_servicios.Regresar') !!}</a>
    <div class="col-md-12" id="main-url" data-url="{{URL::to('/')}}">
        <div class="row">
            <div class="col-md-12">
                <div class="row mb-2">
                    @include('sections.contracts.form.filters')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugins')
@endpush
