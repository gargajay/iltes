<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner">
        <div class="main_title">Add a {{$title}}</div>
        <div class="sub_title">{{$title}} Information</div>
    <form action="{{url('backend/'.lcfirst($title))}}" method="POST">
       @csrf

       @php
           $form2 = 'backend/'.lcFirst($title).'s/form';
       @endphp
       
       @include($form2 , ['model' => ''])
        <div class="row">
            <div class="col-md-12">
                <button  class="save_btn">Save</button>
            </div>
        </div>
    </form>    

    </div>




    @section('script')
    <script>
    </script>

    @endsection

      
    
</x-admin-layout>