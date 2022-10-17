<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-configuration','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            {!! Form::hidden('fk_id_configuration_subtype', (isset($idConfiguration) ? $idConfiguration : null), ['id'=>'fk_id_configuration_subtype']) !!}
            {!! Form::hidden('fk_id_contract', (isset($idContract) ? $idContract : null), ['id'=>'fk_id_contract']) !!}

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_parametric">{!! trans('form\labels.tipoDeMoneda') !!}(*):</label>
                    {!!Form::select('fk_id_parametric',$currencys, (isset($contract) ? $contract->fk_id_parametric : null) ,[
                        'class'=>'form-control selectpicker fk_id_parametric is_required',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_parametric',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
        </div>
        <div class="form-actions ">
            <hr>
            <div class="col-md-6 col-xs-12">
                <div class="form-group form-md-line-input has-info">
                    <button type="button" class='btn btn-danger close-alert-modal btn-block'>
                        {!! trans('messages\buttons.cancelar') !!} <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <button type="button" class="btn btn-success btn-block btn-save-configuration" id="btn-save-configuration">
                    {!! trans('messages\buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
            </div>
        </div>

    {!! Form::close() !!}
</div>
