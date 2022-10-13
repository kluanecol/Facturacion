<div class="col-md-4">
    <div class="form-group ">
        <label for="id_project">{!! trans('form\labels.proyecto') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_project', $projects, null, [
            'class' => 'form-control selectpicker',
            'title'=>trans('messages\general.seleccioneEl').' '.trans('form\labels.proyecto') ,
            'data-actions-box'=>'true',
            'multiple'=>'multiple',
            'data-deselect-all-text'=>trans('messages\general.ninguno'),
            'data-select-all-text'=>trans('messages\general.seleccionarTodo'),
            'id' => 'id_project',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

<div class="col-md-4">
    <div class="form-group ">
        <label for="id_client">{!! trans('form\labels.cliente') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_client', $clients, null, [
            'class' => 'form-control selectpicker',
            'title'=>trans('messages\general.seleccioneEl').' '.trans('form\labels.cliente'),
            'data-actions-box'=>'true',
            'multiple'=>'multiple',
            'data-deselect-all-text'=>trans('messages\general.ninguno'),
            'data-select-all-text'=>trans('messages\general.seleccionarTodo'),
            'id' => 'id_client',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="year">{!! trans('form\labels.ano') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('year', $years, null, [
            'class' => 'form-control selectpicker',
            'id' => 'year',
            'required' => 'required',
            'multiple' => 'multiple',
            'data-live-search'=>'true',
            'title'=>trans('messages\general.seleccioneEl').' '.trans('form\labels.ano'),
            'data-actions-box'=>'true',
            'data-deselect-all-text'=>trans('messages\general.ninguno'),
            'data-select-all-text'=>trans('messages\general.seleccionarTodo'),
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
