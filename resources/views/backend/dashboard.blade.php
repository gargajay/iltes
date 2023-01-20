<x-admin-layout >

<?php 
    


   

    ?>
    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
        <div class="dashbaord_outer">
            <div class="row">
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$inquiryC}}</div>
                            <p>Total Inquirys</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon1.png" alt="icon1">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$studentC}}</div>
                            <p>Total Student</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon2.png" alt="icon2">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$recordC}}</div>
                            <p>Total Record</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon3.png" alt="icon3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <div class="content_inner table_content">
        <div class="count_title" style="padding: 10px">Fee Due list</div>

        <div class="table-responsive "  style="background-color:#fff">
            <table id="example1" class="table table-striped" >
                <thead>
                <tr>
                  
                    
                    <th>Name</th>
                    <th>Father name</th>
                    <th>Phone</th>
                    <th>Crouse Type</th>
                    <th>Current Month</th>
                    <th>Due Date</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($items as $item)
                        
                        <tr>
                           
                            <td>{{$item->name}}</td>
                            <td>{{$item->f_name}}</td>
                            <td>{{$item->phone}}</td>
                            <td> <?php echo $item->getType($item->type_id ?? 0) ?> </td>
                            <td>{{$item->fee ? $item->fee->month:"" }}</td>
                            <td>{{$item->fee ? $item->fee->due_date:"" }}</td>

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
    
       

      
    
</x-admin-layout>