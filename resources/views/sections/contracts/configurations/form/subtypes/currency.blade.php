<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-currency','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            {!! Form::hidden('id', (isset($contract) ? $contract->id : null), ['id'=>'id_contract']) !!}

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_currency">{!! trans('form\labels.proyecto') !!}(*):</label>
                    {!!Form::select('fk_id_currency',$projects, (isset($contract) ? $contract->fk_id_currency : null) ,[
                        'class'=>'form-control selectpicker fk_id_currency is_required',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_currency',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
        <hr>
        <div class="form-actions noborder">
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info">
                    <button type="button" class='btn btn-danger close-alert-modal btn-block'>
                        {!! trans('messages\buttons.cancelar') !!} <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-block" id="btn-add-configuration">
                    {!! trans('messages\buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
            </div>
        </div>

    {!! Form::close() !!}
</div>
