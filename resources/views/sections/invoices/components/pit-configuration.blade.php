@foreach ($otherChargeConfiguration as $configuration)
    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info text-primary" style="text-align: left;">
            <label for="spanish_name">{!! trans('labels.nombreEnEspanol') !!}(*):</label>
            {!! Form::text('spanish_name', isset($parametric) ? $parametric->spanish_name : null, ['class' => 'form-control is_required', 'id' => 'spanish_name', 'maxlength'=> '255', 'Style' => 'width: 100%;']) !!}
            <span class="help-block"></span>
        </div>
    </div>
@endforeach
