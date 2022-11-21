<span class="tool" data-tip="{{trans('buttons.editar')}}"tabindex="1">
    <a  class="btn  btn-warning edit-contract" data-id="{{$contract->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>
</span>

<span class="tool" data-tip="{{trans('buttons.eliminar')}}"tabindex="1">
    <a  class="btn  btn-danger delete-contract" data-id="{{$contract->id}}" target="_blank"><i class="icofont-trash"></i></a>
</span>

<span class="tool" data-tip="{{trans('buttons.configurar')}}"tabindex="1">
    <a href="{{route('contracts.configuration',$contract->id)}}" class="btn  btn-info config-contract" target="_blank"><i class="icofont-options"></i></a>
</span>

<span class="tool" data-tip="{{trans('buttons.facturacion')}}"tabindex="1">
    <a href="{{route('contracts.configuration',$contract->id)}}" class="btn  btn-success" target="_blank"><i class="icofont-briefcase-1"></i></a>
</span>


