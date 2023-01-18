{{-- <div class="row">
    <div class="col-md-6">
        <x-c-input name="name"   value="{{$model ? $model->name:''}}" />
    </div>
    @php
        $v = $mainModel->getStatus();
    @endphp
    <div class="col-md-6">
        <x-c-input name="status_id" type="select" :option="$v"   value="{{$model ? $model->status_id:''}}" />

    </div>
</div> --}}

<div class="row">
    <div class="col-md-6">
        <x-c-input name="reading"   value="{{$model ? $model->reading:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input name="listening"   value="{{$model ? $model->listening:''}}" />
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <x-c-input name="writing"   value="{{$model ? $model->writing:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input name="speaking"   value="{{$model ? $model->speaking:''}}" />
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <x-c-input name="overall"   value="{{$model ? $model->overall:''}}" />
    </div>
   
</div>









    @php
    $v = $mainModel->getUsers();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <x-c-input name="user_id" type="select" label="Student" :option="$v"   value="{{$model ? $model->user_id:''}}" />

        </div>
    </div>







