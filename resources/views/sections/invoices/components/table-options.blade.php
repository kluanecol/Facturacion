
@if ($invoice->state == 1)
<span class="tool" data-tip="{{trans('buttons.previsualizarExcel')}}"tabindex="1">
    <a href="{{route('invoice.generatePreview',$invoice->id)}}" class="btn  btn-success preview-invoice" target="_blank"><i class="icofont-file-excel"></i></a>
</span>
@endif

@if ($invoice->state == 1)
    <span class="tool" data-tip="{{trans('buttons.eliminar')}}"tabindex="1">
        <a  class="btn  btn-danger delete-invoice" data-id="{{$invoice->id}}" target="_blank"><i class="icofont-trash"></i></a>
    </span>
@endif

@if ($invoice->state < 2)
    <span class="tool" data-tip="{{trans('buttons.configurar')}}"tabindex="1">
        <a href="{{route('contracts.configuration',$invoice->id)}}" class="btn  btn-info config-invoice" target="_blank"><i class="icofont-options"></i></a>
    </span>
@endif



