<div class="col-md-6">
    <div class="form-group ">
        <label for="id_project">{!! trans('form\labels.proyecto') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_project', [14 => 14,16 =>16, 17 => 17], null, [
            'class' => 'form-control selectpicker',
            'title'=>'Seleccione',
            'data-actions-box'=>'true',
            'multiple'=>'multiple',
            'data-deselect-all-text'=>'Ninguno',
            'data-select-all-text'=>'Todos',
            'id' => 'id_project',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="year">{!! trans('form\labels.ano') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('year', [1, 15, 13, 14], null, [
            'class' => 'form-control selectpicker',
            'id' => 'year',
            'required' => 'required',
            'multiple' => 'multiple',
            'data-live-search'=>'true',
            'title'=>'Seleccione',
            'data-actions-box'=>'true',
            'data-deselect-all-text'=>'Ninguno',
            'data-select-all-text'=>'Todos',
        ]) !!}
    </div>
</div>

</div>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
            <button type="button" id="search-contracts" class="btn btn-primary btn-block">
                {!! trans('messages\buttons.consultar') !!}
            </button>
        </div>
    </div>
</div>
