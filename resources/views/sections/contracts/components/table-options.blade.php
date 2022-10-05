
<a  class="btn  btn-warning edit-contract" data-id="{{$contract->id}}" target="_blank"><i class="icofont-pencil-alt-1"></i></a>
<a  class="btn  btn-danger delete-contract" data-id="{{$contract->id}}" target="_blank"><i class="icofont-trash"></i></a>
<a href="{{route('contracts.configuration',$contract->id)}}" class="btn  btn-info config-contract" target="_blank"><i class="icofont-options"></i></a>


