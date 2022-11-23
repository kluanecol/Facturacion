@if ($state == 1)
    <span class="badge badge-secondary"  style="font-size: 12px;">{!! trans('invoices.creada') !!}</span>
@elseif($state == 2)
    <span class="badge badge-info" style="font-size: 12px;">{!! trans('invoices.generada') !!}</span>
@else
    <span class="badge badge-success" style="font-size: 12px;">{!! trans('invoices.finalizada') !!}</span>
@endif

