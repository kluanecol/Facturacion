<div class="col-md-6">
    <div class="form-group ">
        <label for="id_country">{!! trans('labels.pais') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_country', $countries, null, [
            'class' => 'form-control selectpicker',
            'title'=>trans('general.seleccioneEl').' '.trans('labels.pais') ,
            'id' => 'id_country',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group ">
        <label for="id_parent_parametrics">{!! trans('labels.parametricasPadre') !!}(*)</label>
        <span class="help-block"></span>
        {!! Form::select('id_parent_parametrics', $parametricParents, null, [
            'class' => 'form-control selectpicker',
            'title'=>trans('general.seleccioneEl').' '.trans('labels.parametricasPadre') ,
            'id' => 'id_parent_parametrics',
            'required' => 'required',
            'data-live-search'=>'true',
        ]) !!}
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
            <button type="button" id="search-contracts" class="btn btn-primary btn-block">
                {!! trans('buttons.consultar') !!}
            </button>
        </div>
    </div>
</div>
