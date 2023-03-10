<?php 
use Spatie\Permission\Models\Role;
$roles = Role::pluck('name', 'name')->all();
$modelId = $model ? $model->id:"";
?>
<div class="row">
    <div class="col-md-6">
        <x-c-input name="name"    value="{{$model ? $model->name:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input name="f_name" label="Father/husband name"    value="{{$model ? $model->f_name:''}}" />
    </div>
    {{-- <div class="col-md-6">
        <x-c-input name="email" type="email"  value="{{$model ? $model->email:''}}" />
    </div> --}}
   
    <div class="col-md-6">
        <x-c-input name="phone" value="{{$model ? $model->phone:''}}" />
    </div>
    
    @php
        $v = $mainModel->getType();
    @endphp
      
      <input type="hidden" name="roles" value="Student">
      <div class="col-md-6">
        <x-c-input name="type_id" type="select" :option="$v"   value="{{$model ? $model->type_id:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input type="textarea" name="address" value="{{$model ? $model->address:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input type="textarea" name="remarks" value="{{$model ? $model->remarks:''}}" />
    </div>

   
   
      
</div>

<script>
   
</script>
