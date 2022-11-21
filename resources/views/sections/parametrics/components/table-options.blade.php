
<a  class="btn  btn-warning edit-parametric" data-id="{{$parametric->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>

@if ( sizeof($parametric->json_countries) == 1)
    <span class="tool" data-tip="{{trans('buttons.cambiarEstado')}}"tabindex="1">
        <a  class="btn  btn-outline-success disable-parametric" data-id="{{$parametric->id}}" target="_blank" > <i class="icofont-power"></i></a>
    </span>
@endif


