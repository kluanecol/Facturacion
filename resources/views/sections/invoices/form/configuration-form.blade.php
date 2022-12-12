
<div id="main-content-form">
    {!! Form::open(['method' => 'POST', 'role' => 'form', 'id' => 'form-invoice-configuration','enctype' => 'multipart/form-data']) !!}

        <div class="tabset">
            <!-- Tab -->
            @foreach ($invoice->json_fk_pits as $pit)
                <input type="radio" name="tabset" id="tab-{{$pit}}" aria-controls="{{$pit}}">
                <label for="tab-{{$pit}}">{{$pit}}</label>
            @endforeach

            <!-- Panels -->
            <div class="tab-panels">
                @foreach ($invoice->json_fk_pits as $pit)

                    <section id="{{$pit}}" class="tab-panel">
                        <h5>{{$pit}}</h5>

                    </section>

                @endforeach
            </div>
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
