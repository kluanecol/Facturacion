<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{$configuration->id}}">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$configuration->id}}" aria-expanded="true" aria-controls="collapse-{{$configuration->id}}">
                <i class="{{$configuration->icon}}" style="font-size: 35;"></i>{{$configuration->name}}
            </a>
        </h4>
    </div>
    <div id="collapse-{{$configuration->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$configuration->id}}">
        <div class="panel-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod in mi quis dapibus. Sed eros orci, ultrices et lacus rhoncus, ultrices suscipit libero. Nunc laoreet, ligula mattis imperdiet convallis, sapien nisi auctor dui, nec scelerisque nulla massa et magna.
        </div>
    </div>
</div>
