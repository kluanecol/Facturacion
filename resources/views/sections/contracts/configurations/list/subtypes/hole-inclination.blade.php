<table class="table table-hover table-bordered" id="table-diameters" style="width: 100%;">
    <thead class="text-light thead-dark">
        <th class="text-center"><strong>{!! trans('labels.diametro') !!}s</strong></th>
        <th class="text-center"><strong>{!!trans('labels.desde') !!}</strong></th>
        <th class="text-center"><strong>{!!trans('labels.hasta') !!}</strong></th>
        <th class="text-center" style="width: 10%;"><strong>{!!trans('labels.incrementoPorPorcentaje') !!} %</strong></th>
        <th class="text-center"><strong>{!! trans('labels.valorIncremento') !!} <span class="text-success">{{isset($configurationCurrency) ? $configurationCurrency->currency->description : ''}}</span></strong></th>
        @if (isset($configurationSecondCurrency))
            <th class="text-center"><strong>{!! trans('labels.valorAlterno') !!} <span class="text-warning">{{$configurationSecondCurrency->secondCurrency->description}}</span></strong></th>
        @endif
        <th class="text-center"><strong>{!! trans('labels.opciones') !!}</strong></th>
    </thead>
    <tbody class="text-center bg-light">
            @foreach ($configurations as $configuration)
                <tr>
                    <td> <h6 class="mt-4"><b>{{$configuration->parametrics_names}}</b></h6></td>
                    <td>
                        <div class="col-md-12 pt-2">
                            <h6 class="text-primary"><b>{{$configuration->initial_range}}</b></h6>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                                <input name="initial_range" type="range" class="form-range form-control range" min="0" max="1000" step="50" value="{{$configuration->initial_range}}" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 pt-2">
                            <h6 class="text-primary"><b>{{$configuration->final_range}}</b></h6>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
                                <input name="final_range" type="range" class="form-range form-control range" min="0" max="1000" step="50" value="{{$configuration->final_range}}" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="mt-4"><b>{{$configuration->charge_by_percentage == 1 ? number_format($configuration->value,2,",",".") : "NO"}}</b></p>
                    </td>
                    <td>
                        <p class="mt-4"><b>{{$configuration->charge_by_percentage == 0 ? number_format($configuration->value,2,",",".") : "NO"}}</b></p>
                    </td>
                    @if (isset($configurationSecondCurrency))
                        <td>
                            <p class="mt-4"><b>{{$configuration->charge_by_percentage == 0 ? number_format($configuration->second_value,2,",",".") : "NO"}}</b></p>
                        </td>
                    @endif
                    <td>
                        <div class="mt-4">
                            <a  class="btn  btn-warning edit-configuration" data-configuration-id="{{$configuration->fk_id_configuration_subtype}}" data-contract-configuration-id="{{$configuration->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>
                            @if ($configuration->configurationSubtype->multiple == 1)
                                <a  class="btn  btn-danger delete-configuration" data-configuration-id="{{$configuration->fk_id_configuration_subtype}}" data-contract-configuration-id="{{$configuration->id}}" target="_blank"><i class="icofont-trash"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach

    </tbody>
</table>
