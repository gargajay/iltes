<div class="row">
    <div class="col-md-6">
        <x-c-input name="name"   value="{{$model ? $model->name:''}}" />
    </div>
    @php
        $v = $mainModel->getStatus();
    @endphp
    <div class="col-md-6">
        <x-c-input name="status_id" type="select" :option="$v"   value="{{$model ? $model->status_id:''}}" />

    </div>
</div>
<div class="row">
        <div class="sub_title">Permission:</div>
        <span class="invalid">
            @if($errors->has('permission'))
                {{ $errors->first('permission') }}
            @endif
        </span>

        <div class="row">
            <div class="col-md-12">
                <div class="info-box">
                <label class="info_check">Check All
                  <input type="checkbox" id="checkall"  onclick="toggle(this);">
                  <span class="checkmark"></span>
                </label>
               
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($permission as $value)
            
                <div class="col-md-6">
                    <div class="info-box">
                        <label class="info_check">{{ $value->name }}
                          <input class="name list ch_{{$value->name}}" data-main="{{$value->name}}" id="{{$value->id}}" name="permission[]" type="checkbox" value="{{$value->id}}" @if(in_array($value->id, $rolePermissions)) checked
                              
                          @endif>
                          <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            @endforeach     
       </div>
</div>