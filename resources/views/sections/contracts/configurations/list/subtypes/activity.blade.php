<table class="table table-hover table-bordered" id="table-activities" style="width: 100%;">
    <thead class="text-light thead-dark">
        <th class="text-center"><strong>{!! trans('form\labels.actividad') !!}</strong></th>
        <th class="text-center"><strong>{!! trans('form\labels.valor') !!}</strong></th>
        <th class="text-center"><strong>{!! trans('form\labels.opciones') !!}</strong></th>
    </thead>
    <tbody class="text-center bg-light">

        @foreach ($configurations as $configuration)
            <tr>
                <td>
                    <p><b>{{$configuration->activity->name}}</b></p>
                </td>
                <td>
                    <p><b>{{$configuration->value}}</b></p>
                </td>
                <td>
                    <a  class="btn  btn-warning edit-configuration" data-configuration-id="{{$configuration->fk_id_configuration_subtype}}" data-contract-configuration-id="{{$configuration->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>

                    @if ($configuration->configurationSubtype->multiple == 1)
                        <a  class="btn  btn-danger delete-configuration" data-id="{{$configuration->id}}" target="_blank"><i class="icofont-trash"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
