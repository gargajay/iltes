<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner">
        <div class="main_title">Add a {{$title}}</div>
        <div class="sub_title">{{$title}} Information</div>
    <form action="{{url('backend/'.lcfirst($title))}}" method="POST">
       @csrf
       
       @include('backend.roles.form', ['model' => ''])
        <div class="row">
            <div class="col-md-12">
                <button  class="save_btn">Save</button>
            </div>
        </div>
    </form>    

    </div>




    @section('script')
    <script>

        
                
            
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