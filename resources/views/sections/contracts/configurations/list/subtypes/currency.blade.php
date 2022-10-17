<table class="table table-hover table-bordered" id="table-currencys" style="width: 100%;">
    <thead class="bg-success text-light">
        <th class="text-center"><strong>{!! trans('form\labels.moneda') !!}</strong></th>
        <th class="text-center"><strong>{!! trans('form\labels.opciones') !!}</strong></th>
    </thead>
    <tbody class="text-center bg-light">
        <tr>
        @foreach ($configurations as $configuration)
        <td>
            <p><b>{{$configuration->currency->name.' '.$configuration->currency->description}}</b></p>
        </td>
        <td>
            <a  class="btn  btn-warning edit-configuration" data-id="{{$configuration->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>
            @if ($configuration->configurationSubtype->multiple == 1)
                <a  class="btn  btn-danger delete-configuration" data-id="{{$configuration->id}}" target="_blank"><i class="icofont-trash"></i></a>
            @endif
        </td>
        @endforeach
        </tr>
    </tbody>
</table>
