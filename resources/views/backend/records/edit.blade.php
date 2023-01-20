<x-admin-layout >

   

    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
    @php
        $student = $model->student;
    @endphp

    <div class="table-responsive card-body" style="background-color: aliceblue">
        <table id="example1" class="table table-borderd" style="width:100%">
            <thead>
            <tr >
                <th colspan="2">
                   
                   Student Information
                </th>
              
            </tr>
            </thead>
            <tbody>
                <tr>
                    <th width="30%">
                       Name
                    </th>
                  <td>{{$student->name}}</td>
                </tr>
                <tr>
                    <th width="30%">
                       Dob
                    </th>
                  <td>{{$student->dob}}</td>
                </tr>
                <tr>
                    <th>
                       Father Name
                    </th>
                  <td>{{$student->f_name}}</td>
                </tr>
                <tr>
                    <th>
                       Phone
                    </th>
                    <td>{{$student->phone}}</td>
                </tr>
                <tr>
                    <th>
                       Parnent Phone
                    </th>
                    <td>{{$student->parent_no}}</td>
                </tr>
                <tr>
                    <th>
                       Course type
                    </th>
                    <td>{{$student->type_id}}</td>
                </tr>
                <tr>
                    <th>
                       Address
                    </th>
                    <td>{{$student->address}}</td>
                </tr>
               
                 
            </tbody> 
        </table>
    </div> 
   <br/>
    <div class="content_inner mt-10">
        <div class="main_title">Edit a {{$title}}</div>
        <div class="sub_title">{{$title}} Information</div>
    <form  method="POST"  action="{{url('backend/'.lcFirst($title).'/'.$model->id)}}">
        @method('PUT')

       @csrf
       
       @php
           $form2 = 'backend/'.lcFirst($title).'s/form';
       @endphp
       @include( $form2 , ['model' => $model])
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