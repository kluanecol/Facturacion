<div id="main-content-form">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-parametric','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="json_countries">{!! trans('labels.pais') !!}(*)</label>
                    {!! Form::select('json_countries[]', $countries, null, [
                        'class' => 'form-control selectpicker is_required',
                        'title'=>trans('general.seleccioneEl').' '.trans('labels.pais') ,
                        'id' => 'json_countries',
                        'multiple' => 'multiple',
                        'data-live-search'=>'true',
                        'data-actions-box' => 'true',
                        'data-deselect-all-text' => trans('general.ninguno'),
                        'data-select-all-text' => trans('general.seleccionarTodo'),
                    ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_parent">{!! trans('labels.grupoDeParametricas') !!}(*):</label>
                    {!!Form::select('fk_id_parent',$parents,null,[
                        'class'=>'form-control selectpicker fk_id_parent is_required',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_parent',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>

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
                    {!! Form::text('english_name', null,
                        [
                            'class' => 'form-control',
                            'id' => 'english_name',
                            'maxlength'=> '255',
                            'Style' => 'width: 100%;'
                        ])
                    !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_auxiliary_parametric">{!! trans('labels.parametricaAuxiliar') !!}(*):</label>
                    {!!Form::select('fk_id_auxiliary_parametric',$auxiliary, 0,[
                        'class'=>'form-control selectpicker fk_id_auxiliary_parametric',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_auxiliary_parametric',
                        'placeholder' => trans('general.seleccionOpcional'),
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
                    <button type="button" class="btn btn-warning btn-block btn-add" id="btn-add">
                        {!! trans('buttons.actualizar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-success btn-block btn-add" id="btn-add">
                        {!! trans('buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
</div>
