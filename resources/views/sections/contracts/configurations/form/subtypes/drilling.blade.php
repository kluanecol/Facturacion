<div id="main-content-form">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-configuration','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            {!! Form::hidden('fk_id_configuration_subtype', (isset($idConfiguration) ? $idConfiguration : null), ['id'=>'fk_id_configuration_subtype']) !!}
            {!! Form::hidden('fk_id_contract', (isset($idContract) ? $idContract : null), ['id'=>'fk_id_contract']) !!}
            {!! Form::hidden('id', (isset($contractConfiguration) ? $contractConfiguration->id : null), ['id'=>'id']) !!}

            <!--div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_activity">{!! trans('form\labels.broca') !!}(*):</label>
                    {!!Form::select('fk_id_activity',[], (isset($contractConfiguration) ? $contractConfiguration->fk_id_activity : null) ,[
                        'class'=>'form-control selectpicker fk_id_activity is_required',
                        'data-live-search'=>'true',
                        'title'=>'',
                        'id'=>'fk_id_activity',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div-->

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_activity">{!! trans('form\labels.valorPorHora') !!}(*):</label>
                    {!! Form::number('value', isset($contractConfiguration) ? $contractConfiguration->value : null, ['class' => 'form-control is_required', 'id' => 'value', 'min'=> '0', 'Style' => 'width: 100%;']) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12"><hr>
                <div class="wrapper">
                    <div class="values">
                        <span id="initial_range_container">
                            0
                        </span>
                        <span> &dash; </span>
                        <span id="final_range_container">
                            1000
                        </span>
                    </div>
                </div><br>
            </div>

            <div class="col-md-3 pt-1"><label for="initial_range">{!! trans('form\labels.desde') !!}:</label></div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <input name="initial_range" type="range" class="form-range form-control range is_required" min="0" max="1000" step="50" id="initial_range" oninput="updateRangeInput(this)" >
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-3"></div>

            <div class="col-md-3 pt-1"> <label for="final_range">{!! trans('form\labels.hasta') !!}:</label></div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <input name="final_range" type="range" class="form-range form-control range biggerthanInitialRange is_required" min="0" max="1000" step="50" id="final_range" oninput="updateRangeInput(this)" >
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-3"></div>
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
            @if (isset($contractConfiguration))
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-warning btn-block btn-save-configuration" id="btn-save-configuration">
                        {!! trans('messages\buttons.actualizar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-success btn-block btn-save-configuration" id="btn-save-configuration">
                        {!! trans('messages\buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
</div>
