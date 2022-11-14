<div id="main-content-form">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-configuration','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            {!! Form::hidden('fk_id_configuration_subtype', (isset($idConfiguration) ? $idConfiguration : null), ['id'=>'fk_id_configuration_subtype']) !!}
            {!! Form::hidden('fk_id_contract', (isset($idContract) ? $idContract : null), ['id'=>'fk_id_contract']) !!}
            {!! Form::hidden('id', (isset($contractConfiguration) ? $contractConfiguration->id : null), ['id'=>'id']) !!}

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="json_fk_parametrics">{!! trans('labels.diametro') !!}(*):</label>
                    {!!Form::select('json_fk_parametrics[]',[
                        trans('contractConfiguration.diametrosPerforacion') => $drillingDiameters,
                        trans('contractConfiguration.diametrosEncamisado') => $casingDiameters], (isset($contractConfiguration) ? $contractConfiguration->parametrics : null) ,[
                        'class'=>'form-control selectpicker json_fk_parametrics is_required',
                        'data-live-search'=>'true',
                        'data-actions-box'=>'true',
                        'multiple'=>'multiple',
                        'data-deselect-all-text'=>trans('general.ninguno'),
                        'data-select-all-text'=>trans('general.seleccionarTodo'),
                        'id' => 'json_fk_parametrics',
                        'required' => 'required',
                        'data-live-search'=>'true',
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-6 mt-2">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align:right;">
                    <label for="charge_by_percentage">{!! trans('labels.incrementoPorPorcentaje') !!}:</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <div class="toggle-radio ">
                        <input  type="radio" name="charge_by_percentage" id="yes" value="1" {{(isset($contractConfiguration) && $contractConfiguration->charge_by_percentage == 1 ? "checked" : "")}}>
                        <input type="radio" name="charge_by_percentage" id="no" value="0" {{(isset($contractConfiguration) ? ($contractConfiguration->charge_by_percentage == 0 ? "checked" : "")  : "checked")}}>
                        <div class="switch">
                            <label for="yes">{!! trans('labels.si') !!}</label>
                            <label for="no">No</label>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12"><hr></div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="value">{!! trans('labels.incremento') !!} (*):</label>
                    {!! Form::number('value', isset($contractConfiguration) ? $contractConfiguration->value : null, ['class' => 'form-control is_required', 'id' => 'value', 'min'=> '0', 'Style' => 'width: 100%;']) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            @if (isset($configurationSecondCurrency))
                <div class="col-md-6">
                    <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                        <label for="second_value">{!! trans('labels.valorAlterno') !!}({!! trans('labels.opcional') !!}) {{isset($configurationSecondCurrency) ? $configurationSecondCurrency->secondCurrency->description : ""}}:</label>
                        {!! Form::number('second_value', isset($contractConfiguration) ? $contractConfiguration->second_value : null,
                            ['class' => 'form-control',
                                'id' => 'second_value',
                                'min'=> '0',
                                'Style' => 'width: 100%;',
                                'disabled' => isset($contractConfiguration) && ($contractConfiguration->charge_by_percentage == 1) ? "disabled" : false
                            ])
                        !!}
                        <span class="help-block"></span>
                    </div>
                </div>
            @endif

            <div class="col-md-12"><hr>
                <div class="wrapper">
                    <div class="values">
                        <span id="initial_range_container">
                            {{isset($contractConfiguration) ? $contractConfiguration->initial_range : 0}}
                        </span>
                        <span> &dash; </span>
                        <span id="final_range_container">
                            {{isset($contractConfiguration) ? $contractConfiguration->final_range : 180}}
                        </span>
                    </div>
                </div><br>
            </div>

            <div class="col-md-3 pt-1"><label for="initial_range">{!! trans('labels.desde') !!}:</label></div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <input name="initial_range" type="range" class="form-range form-control range is_required" min="-360" max="360" step="1" id="initial_range" oninput="updateRangeInput(this)" value="{{isset($contractConfiguration) ? $contractConfiguration->initial_range : 0}}">
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-3"></div>

            <div class="col-md-3 pt-1"> <label for="final_range">{!! trans('labels.hasta') !!}:</label></div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <input name="final_range" type="range" class="form-range form-control range biggerthanInitialRange is_required" min="-360" max="360" step="10" id="final_range" oninput="updateRangeInput(this)"  value="{{isset($contractConfiguration) ? $contractConfiguration->final_range : 180}}">
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-3"></div>

            @include('sections.contracts.configurations.components.button-change-range-input')

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
            @if (isset($contractConfiguration))
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-warning btn-block btn-save-configuration" id="btn-save-configuration">
                        {!! trans('buttons.actualizar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-success btn-block btn-save-configuration" id="btn-save-configuration">
                        {!! trans('buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
</div>
