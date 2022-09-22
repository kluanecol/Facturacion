<div class="col-md-6">
    <div class="form-group ">
        {!! Form::select('id_area', [1,2,3,4], null, [
            'class' => 'form-control select2',
            'multiple' => 'multiple',
            'id' => 'id_area',
            'required' => 'required',
            'data-size' => '5',
        ]) !!}
        <label for="id_area">Área(*)</label>
        <span class="help-block"></span>
    </div>
</div>
<div class="col-md-3">
    <div class="">
        <select name="das[]" id="das" class ="form-control select2" multiple="multiple">
            <option value="more">More food here</option>
            <option value="more1">More food here</option>
            <option value="more2">More food here</option>
            <option value="more3">More food here</option>
            <option value="more4">More food here</option>
            <option value="more5">More food here</option>
            <option value="more6">More food here</option>
        </select>

        <label for="i_periodo">Año(*)</label>
        <span class="help-block"></span>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group form-md-line-input has-info">
       <select class="form-control" name="a" id="a">

            @for ($i = 0; $i < 9; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
       </select>
    </div>
</div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
            <button type="button">
                <i class="fa fa-eye" aria-hidden="true"></i>
                Consultar Lotes Enviados
            </button>
        </div>
    </div>
</div>
