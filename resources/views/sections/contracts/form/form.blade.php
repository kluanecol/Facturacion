<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-contract','enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info">
                    <label for="id_project">Proyecto(*)</label>
                    <span class="help-block"></span>
                    {!!Form::select('id_project',[], null,[
                        'class'=>'form-control selectpicker id_project ',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione el proyecto',
                        'id'=>'id_project',
                        'required' => 'required',
                        'data-size'=>'5'
                    ])!!}

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="year">{!! trans('form\labels.ano') !!}(*)</label>
                    <span class="help-block"></span>
                    {!! Form::select('year', [1, 15, 13, 14], null, [
                        'class' => 'form-control selectpicker',
                        'id' => 'year',
                        'required' => 'required',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione',
                    ]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info ">
                    <label for="initial_date">Fecha Inicio</label>
                    <div class="input-icon">
                        {!! Form::date('initial_date',null, [
                            'class' => 'form-control ',
                            'id' => 'initial_date',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info ">
                    <label for="end_date">Fecha Fin</label>
                    <div class="input-icon">
                        {!! Form::date('end_date', null, [
                            'class' => 'form-control ',
                            'id' => 'end_date',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions noborder">
            <button type="button" class="btn btn-success btn-block" id="btn-add">
                <i class="fa fa-send" aria-hidden="true"></i>
                Guardar
            </button>
        </div>

    {!! Form::close() !!}
</div>
