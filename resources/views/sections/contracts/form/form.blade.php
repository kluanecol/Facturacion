<div id="main_contenido_formulario">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-contract','enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="id_project">Proyecto(*):</label>

                    {!!Form::select('id_project',[1,2,3,4,5,6,7,8,9], null,[
                        'class'=>'form-control selectpicker id_project ',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione el proyecto',
                        'id'=>'id_project',
                        'required' => 'required',
                        'data-size'=>'5'
                    ])!!}
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                    <label for="year">{!! trans('form\labels.ano') !!}(*):</label>
                    {!! Form::select('year', [1, 15, 13, 14], null, [
                        'class' => 'form-control selectpicker',
                        'id' => 'year',
                        'required' => 'required',
                        'data-live-search'=>'true',
                        'title'=>'Seleccione',
                    ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="initial_date">Fecha Inicio(*):</label>
                        {!! Form::date('initial_date',null, [
                            'class' => 'form-control ',
                            'id' => 'initial_date',
                            'required' => 'required',
                            'title'=>'',
                        ]) !!}
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-md-line-input has-info text-primary " style="text-align: left;">
                    <label for="end_date">Fecha Fin(*):</label>
                        {!! Form::date('end_date', null, [
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
