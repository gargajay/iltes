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
    <div class="col-md-6">
        <x-c-input name="phone"   value="{{$model ? $model->phone:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input name="email"   value="{{$model ? $model->email:''}}" />
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="editor_form">
            <x-c-input type="textarea" name="address"   value="{!! $model ? $model->address:'' !!}" />
        </div>
    </div>
    <div class="col-md-6">
        <label class="custom_label" >Lab Logo</label>

        <div class="drop_outer">
            <div class="drop_inner">
                <div class="upload__files" >
                @if(!empty($model))
                   <img src="{{$model->logo}}" alt="" width="100%" height="200px">
                @else
              
                    <img src="{{asset('backend/assets/images/Camera.png')}}"  alt="Camera">
                <p>Drag Your Images to Upload
                or <span>Browse</span></p>
    
               
                @endif
            </div>
               
                <input type="file" name="logo" id="profile">
                <p>Drag Your Images to Upload
                    or <span>Browse</span></p>
            </div>
        </div>
    </div>
</div>






@role('Super-Admin')
    @php
    $v = $mainModel->getUsers();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <x-c-input name="user_id" type="select" :option="$v"   value="{{$model ? $model->user_id:''}}" />

        </div>
    </div>
@else
  <input type="hidden" name="user_id" id="" value="{{auth()->id()}}" >
@endrole







