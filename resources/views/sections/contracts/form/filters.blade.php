<div class="col-md-6">
    <div class="form-group form-md-line-input has-info">
        {!! Form::select('id_area[]', [1,2,3], null, [
            'class' => 'form-control selectpicker id_area ',
            'data-live-search' => 'true',
            'title' => 'Seleccione el área a la que se envío el lote de pagos',
            'data-actions-box' => 'true',
            'multiple' => 'multiple',
            'data-deselect-all-text' => 'Ninguno',
            'data-select-all-text' => 'Todos',
            'id' => 'id_area',
            'required' => 'required',
            'data-size' => '5',
        ]) !!}
        <label for="id_area">Área(*)</label>
        <span class="help-block"></span>
    </div>
</div>
<div class="col-md-3">
    <div class="">
        <select name="das" id="das" class ="selectpicker" data-live-search = "true" title = "Seleccione el año">
            <option data-tokens="more">More food here</option>
            <option data-tokens="more1">More food here</option>
            <option data-tokens="more2">More food here</option>
            <option data-tokens="more3">More food here</option>
            <option data-tokens="more4">More food here</option>
            <option data-tokens="more5">More food here</option>
            <option data-tokens="more6">More food here</option>
        </select>

        <label for="i_periodo">Año(*)</label>
        <span class="help-block"></span>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group form-md-line-input has-info">
       <select class=" form-control" name="a" id="a">

            @for ($i = 0; $i < 9; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
       </select>
    </div>
</div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
            <button type="button" class='btn blue consultar-lotes-pago btn-block'>
                <i class="fa fa-eye" aria-hidden="true"></i>
                Consultar Lotes Enviados
            </button>
        </div>
    </div>
</div>
