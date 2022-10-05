<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-contract','enctype' => 'multipart/form-data']) !!}
        <div class="row">

            {!! Form::hidden('id', (isset($contract) ? $contract->id : null), ['id'=>'id_project']) !!}

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_project">{!! trans('form\labels.proyecto') !!}(*):</label>
                    {!!Form::select('fk_id_project',$projects, (isset($contract) ? $contract->fk_id_project : null) ,[
                        'class'=>'form-control selectpicker fk_id_project ',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione el proyecto',
                        'id'=>'fk_id_project',
                        'required' => 'required',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="fk_id_client">{!! trans('form\labels.cliente') !!}(*):</label>
                    {!!Form::select('fk_id_client',$clients, (isset($contract) ? $contract->fk_id_client : null) ,[
                        'class'=>'form-control selectpicker fk_id_client ',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione el cliente',
                        'id'=>'fk_id_client',
                        'required' => 'required',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="year">{!! trans('form\labels.ano') !!}(*):</label>
                    {!! Form::select('year', $years, (isset($contract) ? $contract->year : null), [
                        'class' => 'form-control selectpicker',
                        'id' => 'year',
                        'required' => 'required',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione',
                    ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="initial_date">{!! trans('form\labels.fechaInicial') !!}(*):</label>
                        {!! Form::date('initial_date',(isset($contract) ? $contract->initial_date : null), [
                            'class' => 'form-control ',
                            'id' => 'initial_date',
                            'required' => 'required',
                            'title'=>'',
                        ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="end_date">{!! trans('form\labels.fechaFinal') !!}(*):</label>
                        {!! Form::date('end_date', (isset($contract) ? $contract->end_date : null), [
                            'class' => 'form-control ',
                            'id' => 'end_date',
                            'required' => 'required',
                            'title'=>'',
                        ]) !!}
                        <span class="help-block"></span>
                </div>
            </div>

        </div>
        <hr>
        <div class="form-actions noborder">
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info">
                    <button type="button" class='btn btn-danger close-alert-modal btn-block'>
                        Cancelar  <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-block" id="btn-add">
                    Guardar  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
            </div>
        </div>

    {!! Form::close() !!}
</div>
