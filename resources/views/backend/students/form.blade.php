<?php 
use Spatie\Permission\Models\Role;
$roles = Role::pluck('name', 'name')->all();
$modelId = $model ? $model->id:"";
$auth = Auth::user();
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
    <div class="col-md-6">
        <x-c-input type="date" name="dob" value="{{$model ? $model->dob:''}}" />
    </div>


    @if(!Auth::user()->hasRole('Super-Admin') || !Auth::user()->hasRole('Staff')  )
    <div class="col-md-6">
        <x-c-input name="parent_no" label="Parent phone no" value="{{$model ? $model->parent_no:''}}" />
    </div>
    
    @php
        $v = $mainModel->getType();
    @endphp
      
      <input type="hidden" name="roles" value="Student">
      <div class="col-md-6">
        <x-c-input name="type_id" type="select" :option="$v"   value="{{$model ? $model->type_id:''}}" />
    </div>
    <div class="col-md-12">
        <x-c-input type="textarea" name="address" value="{{$model ? $model->address:''}}" />
    </div>
    @endif
   
      
</div>

<script>
   
</script>
