<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner">
        <div class="main_title">My Profile</div>
        <div class="sub_title">My Profile Information</div>
    <form  method="POST"  action="{{url('backend/change-password')}}" enctype="multipart/form-data">

       @csrf

       <div class="row">
            <div class="col-md-6">
                <x-c-input name="password" type="password"  value="" />
            </div>
            <div class="col-md-6">
                <x-c-input name="new_password" label="New password" type="password"  value="" />
            </div>
          
       </div>
      
       
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