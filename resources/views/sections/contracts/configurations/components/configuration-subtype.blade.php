<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{$configuration->id}}">
        <h4 class="panel-title">
            <a class="collapse configuration-collapse" data-id="{{$configuration->id}}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$configuration->id}}" aria-expanded="true" aria-controls="collapse-{{$configuration->id}}">
                <div>
                    <i class="{{$configuration->icon}}" style="font-size: 35;"></i>{{$configuration->name}}
                    <button type="button" class="btn btn-xs btn-primary add-configuration pull-right" data-id="{{$configuration->id}}">
                        {!! trans('messages\buttons.agregar') !!} <span style="font-size: 16"><b> + </b></span>
                    </button>
                </div>

            </a>
        </h4>
    </div>
    <div id="collapse-{{$configuration->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$configuration->id}}">
        <div class="panel-body" id="container-configuration-{{$configuration->id}}">

        </div>
    </div>
</div>
