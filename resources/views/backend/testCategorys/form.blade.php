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

    @php
    $v = $mainModel->getLabs();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <x-c-input name="lab_id" type="select" :option="$v"   value="{{$model ? $model->lab_id:''}}" />

        </div>
    </div>



















