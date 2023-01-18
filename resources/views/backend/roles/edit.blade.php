<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner">
        <div class="main_title">Edit a {{$title}}</div>
        <div class="sub_title">{{$title}} Information</div>
    <form  method="POST"  action="{{url('backend/'.lcFirst($title).'/'.$model->id)}}">
        @method('PUT')

       @csrf
       
       @include('backend.roles.form', ['model' => $model])
        <div class="row">
            <div class="col-md-12">
                <button  class="save_btn">Update</button>
            </div>
        </div>
    </form>    

    </div>




    @section('script')
    <script>

          jQuery('.list').each(function() 
            {

                var check2 = true;
                if(!this.checked){
                    check2 = false;
                }

                if(!check2){
                jQuery('#checkall').prop('checked',false);

                }else{
                jQuery('#checkall').prop('checked',true);

                }
            });  
         
            
        function toggle(source)
         {
           
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        jQuery('.list').click(function()
         {
            var check2 = true;
            jQuery('.list').each(function() 
            {

                if(!this.checked){
                    check2 = false;
                }

                if(!check2){
                jQuery('#checkall').prop('checked',false);

                }else{
                jQuery('#checkall').prop('checked',true);

                }
            });   
          });



      

      
    </script>

    @endsection

      
    
</x-admin-layout>