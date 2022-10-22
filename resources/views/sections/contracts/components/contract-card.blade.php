{!! Form::hidden('id_contract', (isset($contract) ? $contract->id : null), ['id'=>'id_contract']) !!}
<div class="col-md-12">
    <div class="course">
        <div class="col-md-12 col-xs-12 text-center">
            <div class="course-preview">
                <h6>{!! trans('contracts.datosDelContrato') !!} ID: {{(isset($contract) ? $contract->id : 'N/R')}}</h6>
                <h5>{{(isset($contract) ? $contract->project->nombre_corto : 'N/R')}}</h5>
                <h5>{{(isset($contract) ? $contract->client->nombre_cliente : 'N/R')}}</h5>
                <h5>{{(isset($contract) ? $contract->initial_date.' - '.$contract->end_date : 'N/R')}}</h5>
            </div>
            <div class="bg-light py-3">
                <p><b>INVOICING</b></p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
            </div>
        </div>
    </div>
</div>
