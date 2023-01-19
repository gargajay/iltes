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
                 {{$title}} List for {{$user->name}} 
             </div>
             <form action="" id="myform">
             <div class="add_new_product">
                
                <div class="hide" style="display:none">
                    <span id="count">0</span>  Row Selected &nbsp;
                    {{-- @can(lcFirst($title)."-delete")

                    <a class="view_all create" onclick="deleteAll()" ><i class="fa fa-trash "></i></a>
                    @endcan --}}
                </div>
                Total fee {{$totalfee}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a class="view_all create" href="{{url('backend/'.lcFirst($title)."/create?id=".$user_id)}}">+ Add New {{$title}}</a>
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
                    
                    <th>Month</th>
                    <th>Year</th>
                    <th>Amount</th>
                    <th>Created Date</th>
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
                            <td>{{$item->month}}</td>
                            <td>{{$item->year}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->created_at}}</td>

                            <td> 
                                {{$item->getStatus($item->status)}}
                            </td>
                            {{-- <td>
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
                            </td> --}}
                            <td>
                               
                                    <form method="POST" action="{{url('backend/'.lcFirst($title)."/".$item->id."?user_id=".$user_id)}}">
                                        @csrf
                                        @method('delete')
                                        
                                            @can(lcFirst($title)."-delete")
                                            <a  class="delete" ><i class="fa fa-trash text-danger"></i></a> |
                                            @endcan
                                            @can(lcFirst($title)."-edit")
                                        <a href="{{url('backend/'.lcFirst($title)."/".$item->id.'/edit?user_id='.$user_id)}}" class=" "><i class="fa fa-edit text-sucess"></i></a>
                                          
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
    var uId = "{{$user_id}}";


    jQuery(function($){ 
        $(document).on('keypress', '.search_bar', function(e)
        {
            if(e.which == 13) 
            {
                var name =  $(".search_bar").val();
                var furl = uri+"?id="+uId+"&name="+name;
                return window.location.href =   furl;

               
          
            }
        });
        
        $(document).on('blur', '.search_bar', function()
        {
            
            var name =  $(".search_bar").val();
                var furl = uri+"?id="+uId+"&name="+name;
                return window.location.href =   furl;

          
        });
    
        $(document).on('change', '.search_bar_dropdown', function(e){
            var name =  $(".search_bar").val();
                var furl = uri+"?id="+uId+"&name="+name;
                return window.location.href =   furl;

           
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
         
           return window.location.href =   uri + '/status/'+id+ '/' + status + '?id=' + uId;

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