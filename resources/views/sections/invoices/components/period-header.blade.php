<div class="col-md-12 bg-secondary">
    <h6 class="pt-2">{{trans('invoices.periodoDeFacturacion').": ".$invoice->period}}
            @if ($invoice->state != 3)
            <span class="tool" data-tip="{{trans('buttons.crearNuevaVersion')}}">
                <a  class="btn btn-info add-new-version" data-id="{{$invoice->id}}" target="_blank"><i class="fa fa-plus-circle"></i></a>
            </span>
        @endif
    </h6>
</div>



