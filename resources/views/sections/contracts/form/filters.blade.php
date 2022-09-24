<div class="col-md-6">
    <div class="form-group ">
        <label for="id_project">{!! trans('form\labels.proyecto') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_project', [1, 2, 3, 4], null, [
            'class' => 'form-control select2',
            'multiple' => 'multiple',
            'id' => 'id_project',
            'required' => 'required'
        ]) !!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="year">{!! trans('form\labels.ano') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('year', [1, 2, 3, 4], null, [
            'class' => 'form-control select2',
            'id' => 'year',
            'required' => 'required',
            'multiple' => 'multiple',
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
