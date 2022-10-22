<div class="col-md-12">
    <div class="form-group ">
        <label for="id_configuration_subtype">{!! trans('labels.tipoDeConfiguracion') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_configuration_subtype', is_object($configurationSubtypes) ? $configurationSubtypes->pluck('name','id') : [], null, [
            'class' => 'form-control selectpicker',
            'title'=>'Seleccione el tipo de configuracion a agregar',
            'id' => 'id_configuration_subtype',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
            <button type="button" id="add-subtype-form" class="btn btn-primary btn-block">
                {!! trans('buttons.agregarNuevaConfiguracion') !!}
            </button>
        </div>
    </div>


