<x-admin-layout >

   @php
       $title2 = lcFirst($title);
   @endphp

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
   
    <div class="content_inner table_content">
        <div class="material_request_outer">
             <div class="main_title">
                 {{$title}} List
             </div>
             <form action="">
             <div class="add_new_product">
                
                <div class="hide" style="display:none">
                    <span id="count">0</span>  Row Selected &nbsp;
                    @can(lcFirst($title)."-delete")

                    <a class="view_all create" onclick="deleteAll()" ><i class="fa fa-trash "></i></a>
                    @endcan
                </div>
               <a class="view_all create" href="{{url('backend/'.lcFirst($title)."/create")}}">+ Add New {{$title}}</a>
               <input class="custom_input search search_bar" type="text" placeholder="Type here..." name="name" value="{{$name}}">
             </div>   
            </form> 
        </div>
        <div class="table-responsive">
            <table id="example1" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>
                        <label class="info_check"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            S.no
                            <input type="checkbox" id="checkall"  onclick="toggle(this);">
                            <span class="checkmark"></span>
                          </label>
                       
                    </th>
                    
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($items as $item)
                        
                        <tr>
                            <td><label class="info_check">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $i }}
                                <input class="name list checkId "  data-id="{{$item->id}}" name="All[]" type="checkbox" >
                                <span class="checkmark"></span>
                              </label> </td>  
                            <td>{{$item->name}}</td>
                            <td>
                                <div class="status_div">
                                    <div class="toggle-switch">
                                    <input type="checkbox" @if(!auth()->user()->can(lcFirst($title)."-edit"))
                                    disabled
                                @endif  class="chk-btn" data-id="{{$item->id}}" data-status="<?= ($item->status_id==1) ? 0:1;  ?> " id="chkTest_{{$item->id}}"  name="chkTest_{{$item->id}}" <?= ($item->status_id==1) ? 'checked':"";  ?>  />
                                    <label for="chkTest_{{$item->id}}">
                                        <span class="toggle-track"></span>
                                    </label>
                                    </div>
                                </div>
                            </td>
                            <td>
                               
                                    <form method="POST" action="{{url('backend/'.lcFirst($title)."/".$item->id)}}">
                                        @csrf
                                        @method('delete')
                                        
                                        @can(lcFirst($title)."-delete")
                                        <a  class="delete" ><i class="fa fa-trash text-danger"></i></a> |
                                        @endcan
                                        @can(lcFirst($title)."-edit")
                                        <a href="{{url('backend/'.lcFirst($title)."/".$item->id.'/edit')}}" class=" "><i class="fa fa-edit text-sucess"></i></a>
                                        @endcan
                                    </form>
                                
                                
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @empty
                        <tr>
                            No Record Found !
                        </tr>
                    @endforelse
                </tbody> 
            </table>
        </div> 
    {{-- end table-responsive --}}
        <br/>

        <div class="row">
            <div class="col-sm-12 col-md-7">
                {{ $items->links('vendor.pagination.custom') }}
            </div>
        </div>


    </div> 



@section('script')
<script>
    var uri = "{{ url('backend/'.$title2) }}";
    jQuery(function($){ 
        $(document).on('keypress', '.search_bar', function(e)
        {
            if(e.which == 13) 
            {
                $(this).closest('form').submit()
            }
        });
        
        $(document).on('blur', '.search_bar', function()
        {
            $(this).closest('form').submit()
        });
    
        $(document).on('change', '.search_bar_dropdown', function(e){
            $(this).closest('form').submit()
         });

         $(document).on('click', '.delete', function(e)
         {
            if(confirm('Are you want to delete ?'))
            {
                $(this).closest('form').submit();
            }
         });

         $(".chk-btn").change(function() 
         {
            var id =  $(this).data("id");
            var status =  $(this).data("status");
         
           return window.location.href =   uri + '/status/'+id+ '/' + status;

        });


        



        jQuery('.list,#checkall').click(function()
         {
            var check2 = true;
            var count = 0;
            jQuery('.list').each(function() 
            {

                if(this.checked){
                    count++;
                }

                if(!this.checked){
                    check2 = false;
                }

                if(!check2){
                jQuery('#checkall').prop('checked',false);

                }else{
                jQuery('#checkall').prop('checked',true);

                }
            }); 


            if(count>0){
                $(".hide").show();
            }else{
                $(".hide").hide();

            }

            $("#count").html(count);

          });




         });
         function toggle(source)
         {
           
            var checkboxes = document.querySelectorAll('.checkId');
            for (var i = 0; i < checkboxes.length; i++) {
                
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        function deleteAll()
        {
            var a = [];
            if(confirm('Are you want to delete ?'))
            {
                jQuery('.list').each(function() 
                {

                    if(this.checked)
                    {

                        var  id =   $(this).data("id");
                        a.push(id);
                    }
                }); 

                $.ajax({
                    url: uri + '/bulk-delete',
                    type:"POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        ids:a,
                        
                    },
                    success:function(response){
                        console.log(response);
                        if (response) {
                        ajax_message(response.message);
                         window.location.reload();

                        }
                    },
                    error: function(response) {
                        if(response.status  === 422 )
                        {
                            ajax_message(response.responseJSON.message,response.responseJSON.errors);
                        }


                    }
                    });
            }
        }
</script>
@endsection

      
    
</x-admin-layout>