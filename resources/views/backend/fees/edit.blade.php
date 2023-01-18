<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner">
        <div class="main_title">Edit a {{$title}}</div>
        <div class="sub_title">{{$title}} Information</div>
    <form  method="POST"  action="{{url('backend/'.lcFirst($title).'/'.$model->id."?user_id=".$user_id)}}" enctype="multipart/form-data">
        @method('PUT')

       @csrf
       
       @php
           $form2 = 'backend/'.lcFirst($title).'s/form';
       @endphp
       @include( $form2 , ['model' => $model,'userRole'=>[],'roles'=>[]])
        <div class="row">
            <div class="col-md-12">
                <button  class="save_btn">Update</button>
            </div>
        </div>
    </form>    

    </div>




    @section('script')
    <script>
 
    </script>

    @endsection

      
    
</x-admin-layout>