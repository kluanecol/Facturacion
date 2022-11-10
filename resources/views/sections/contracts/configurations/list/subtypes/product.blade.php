<table class="table table-hover table-bordered" id="table-products" style="width: 100%;">
    <thead class="text-light thead-dark">
        <th class="text-center"><strong>{!! trans('labels.grupo') !!}</strong></th>
        <th class="text-center"><strong>{!! trans('labels.consumible') !!}</strong></th>
        <th class="text-center"><strong>{!! trans('labels.valorUnitario') !!} <span class="text-success">{{isset($configurationCurrency) ? $configurationCurrency->currency->description : ''}}</span></strong></th>
        @if (isset($configurationSecondCurrency))
            <th class="text-center"><strong>{!! trans('labels.valorAlterno') !!} <span class="text-warning">{{$configurationSecondCurrency->secondCurrency->description}}</span></strong></th>
        @endif
        <th class="text-center"><strong>{!! trans('labels.opciones') !!}</strong></th>
    </thead>
    <tbody class="text-center bg-light">

        @foreach ($configurations as $configuration)
            <tr>
                <td>
                    <p><b>{{$configuration->product->group->name}}</b></p>
                </td>
                <td>
                    <p><b>{{$configuration->product->name_reference}}</b></p>
                </td>
                <td>
                    <p><b>{{number_format($configuration->value,2,",",".")}}</b></p>
                </td>
                @if (isset($configurationSecondCurrency))
                    <td>
                        <p><b>{{number_format($configuration->second_value,2,",",".")}}</b></p>
                    </td>
                @endif
                <td>
                    <a  class="btn  btn-warning edit-configuration" data-configuration-id="{{$configuration->fk_id_configuration_subtype}}" data-contract-configuration-id="{{$configuration->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>

                    @if ($configuration->configurationSubtype->multiple == 1)
                        <a  class="btn  btn-danger delete-configuration" data-configuration-id="{{$configuration->fk_id_configuration_subtype}}" data-contract-configuration-id="{{$configuration->id}}" target="_blank"><i class="icofont-trash"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
