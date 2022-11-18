<div id="main-content-form">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-other-charge','enctype' => 'multipart/form-data']) !!}
        <div class="row">
            {!! Form::hidden('state', 1 , ['id'=>'state']) !!}
            {!! Form::hidden('fk_id_parent', 3, ['id'=>'fk_id_parent']) !!}

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="spanish_name">{!! trans('labels.nombreEnEspanol') !!}(*):</label>
                    {!! Form::text('spanish_name', null, ['class' => 'form-control is_required', 'id' => 'spanish_name', 'maxlength'=> '255', 'Style' => 'width: 100%;']) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="english_name">{!! trans('labels.nombreEnIngles') !!}:</label>
                    {!! Form::text('english_name', null, ['class' => 'form-control', 'id' => 'english_name', 'maxlength'=> '255', 'Style' => 'width: 100%;']) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_auxiliary_parametric">{!! trans('labels.unidadDeMedida') !!}(*):</label>
                    {!!Form::select('fk_id_auxiliary_parametric',$measures,null,[
                        'class'=>'form-control selectpicker fk_id_auxiliary_parametric is_required',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_auxiliary_parametric',
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
                        {!! trans('buttons.cancelar') !!} <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            @if (isset($parametric))
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-warning btn-block btn-save-parametric" id="btn-save-parametric">
                        {!! trans('buttons.actualizar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-success btn-block btn-save-parametric" id="btn-save-parametric">
                        {!! trans('buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
</div>
