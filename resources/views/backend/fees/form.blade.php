<?php 

$modelId = $model ? $model->id:"";
?>
<div class="row">
    <div class="col-md-6">
        <x-c-input name="amount"    value="{{$model ? $model->amount:''}}" />

    </div>
    <div class="col-md-6">
        <x-c-input name="year"    value="{{$model ? $model->year:''}}" />
    </div>
    
   
   
    
    @php
        $v = $mainModel->getStatus();
        $m = $mainModel->getMonth();
        
    @endphp
      
      <div class="col-md-6">
        <x-c-input name="status" type="select" :option="$v"   value="{{$model ? $model->status:''}}" />
    </div>
    <div class="col-md-6">
        <x-c-input name="month" type="select" :option="$m"   value="{{$model ? $model->month:''}}" />
    </div>
    {{-- <div class="col-md-12">
        <x-c-input type="textarea" name="descripion" value="{{$model ? $model->address:''}}" />
    </div> --}}

    <div class="col-md-12">
        <x-c-input name="due_date" type="date" label="Next due date"   value="{{$model ? $model->month:''}}" />

    </div>
   
   
      
</div>

<script>
   
</script>
