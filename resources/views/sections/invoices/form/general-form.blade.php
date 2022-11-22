<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-contract','enctype' => 'multipart/form-data']) !!}
        <div class="row">
            {!! Form::hidden('id', (isset($invoice) ? $invoice->id : null), ['id'=>'id_invoice']) !!}
            {!! Form::hidden('fk_id_contract', (isset($contract) ? $contract->id : null), ['id'=>'fk_id_contract']) !!}

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="json_fk_machines">{!! trans('labels.maquinas') !!}(*):</label>
                    {!!Form::select('json_fk_machines[]', $machines, (isset($invoice) ? $invoice->json_fk_machines : null) ,[
                        'class'=>'form-control selectpicker json_fk_machines is_required',
                        'data-live-search'=>'true',
                        'data-actions-box' => 'true',
                        'multiple' => 'multiple',
                        'data-deselect-all-text' => trans('general.ninguno'),
                        'data-select-all-text' => trans('general.seleccionarTodo'),
                        'title'=>'',
                        'id'=>'json_fk_machines',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-12"><br></div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="initial_date">{!! trans('labels.fechaInicial') !!}(*):</label>
                        {!! Form::date('initial_date',(isset($invoice) ? $invoice->initial_date : null), [
                            'class' => 'form-control is_required',
                            'id' => 'initial_date',

                            'title'=>'',
                        ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="end_date">{!! trans('labels.fechaFinal') !!}(*):</label>
                        {!! Form::date('end_date', (isset($invoice) ? $invoice->end_date : null), [
                            'class' => 'form-control is_required',
                            'id' => 'end_date',

                            'title'=>'',
                        ]) !!}
                        <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-12 col-xs-12">
                <button type="button" class="btn btn-bordered btn-xs btn-outline-info btn-search-pits" id="btn-search-pits">
                    {!! trans('buttons.buscarPozos') !!}  <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                </button>
            </div>

            <div class="col-md-12">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="json_fk_pits">{!! trans('labels.pozos') !!}(*):</label>
                    {!!Form::select('json_fk_pits[]', isset($pits) ? $pits : [], (isset($invoice) ? $invoice->json_fk_pits : null) ,[
                        'class'=>'form-control selectpicker json_fk_pits is_required',
                        'data-live-search'=>'true',
                        'data-actions-box' => 'true',
                        'multiple' => 'multiple',
                        'data-deselect-all-text' => trans('general.ninguno'),
                        'data-select-all-text' => trans('general.seleccionarTodo'),
                        'title'=>'',
                        'id'=>'json_fk_pits',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>

        </div>
        <hr>
        <div class="form-actions noborder">
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info">
                    <button type="button" class='btn btn-danger close-alert-modal btn-block'>
                        {!! trans('buttons.cancelar') !!} <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            @if (isset($invoice))
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-warning btn-block btn-save-invoice" id="btn-save-invoice">
                        {!! trans('buttons.actualizar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-success btn-block btn-save-invoice" id="btn-save-invoice">
                        {!! trans('buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
</div>
