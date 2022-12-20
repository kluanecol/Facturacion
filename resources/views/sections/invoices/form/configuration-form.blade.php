
<div id="main-content-form" >
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-invoice-configuration','enctype' => 'multipart/form-data']) !!}

        {{ Form::hidden('fk_id_invoice', isset($invoice) ? $invoice->id : null ,['id'=>'fk_id_invoice']) }}

        <div style="max-height: 800px; overflow-y: scroll;">
            <table style="width: 100%;">

                <tbody id="tbody-configurations">
                    @foreach ($invoice->json_fk_pits as $pit)
                        <tr>
                            <td>
                                <hr>
                                <div class="panel-group py-0">
                                    <div class="panel panel-default bg-secondary">
                                        <div class="panel-body text-center">
                                            <h5>
                                                {{$pit}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @foreach ($otherChargeConfigurations as $configuration)
                            <tr class="rowConfiguration">
                                {{ Form::hidden('fk_id_pit', isset($pit) ? $pit : null ,['class'=>'fk_id_pit']) }}
                                {{ Form::hidden('fk_id_configuration', isset($configuration) ? $configuration->id : null ,['class'=>'fk_id_configuration']) }}
                                <td class="text-justify">
                                    <br>
                                    <strong>{{$configuration->charge->NameAndAuxiliaryName}}</strong>
                                    {!!Form::number('quantity', 0 ,['class'=>'form-control is_required','placeholder'=>'','required'=>'required','maxlength'=>'4'])!!}
                                </td>
                            </tr>

                        @endforeach

                    @endforeach

                </tbody>
            </table>
        </div>


        <hr>

        <div class="form-actions noborder">
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="form-group form-md-line-input has-info">
                    <button type="button" class='btn btn-danger close-alert-modal btn-block'>
                        {!! trans('buttons.cancelar') !!} <i class="fa fa-times-circle"  aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-xs-12">
                <button type="button" class="btn btn-success btn-block btn-save-invoice-configuration" id="btn-save-invoice-configuration">
                    {!! trans('buttons.guardar') !!}  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
                <br>
            </div>

        </div>

    {!! Form::close() !!}
</div>
