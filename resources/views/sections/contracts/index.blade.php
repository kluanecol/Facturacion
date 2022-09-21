@extends('layouts.master_panel')
@section('title', trans('menu\titles.contratos'))


@section('content')
    <div class="container-fliud">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <div class="bg-kluane" style="border-radius: 5px;">
                            <h5 class="text-light m-1 py-2"><b>{!! strtoupper(trans('menu\titles.contratos')) !!}</b></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="{{-- route('inventario.compras.index') --}}"
                            class="btn btn-primary btn-sm float-right">{!! trans('inventarios/compras/index_ordenes_servicios.Regresar') !!}</a>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr style="background-color: #275FA9;color: #fff">
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Número orden de servicio') !!}</td>
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Fecha solicitud orden de servicio') !!}</td>
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Proyecto') !!}</td>
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Proveedor') !!}</td>
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Solicitante') !!}</td>
                                        <td>{!! trans('inventarios/compras/index_ordenes_servicios.Acciones') !!}</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugins')
@endpush
