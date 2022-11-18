@if ($state == 1)
    <span class="badge badge-primary"  style="font-size: 12px;">{!! trans('labels.activo') !!}</span>
@else
    <span class="badge badge-secondary" style="font-size: 12px;">{!! trans('labels.inactivo') !!}</span>
@endif

