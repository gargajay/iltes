<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
use App\Models\PermissionModel;
use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Permission;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Redirect;
    use DB;
    use Exception;
    use Facade\FlareClient\Http\Response;
    use Illuminate\Support\Facades\View;

class PermissionController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:permission-edit|permission-list|permission-create|permission-delete', ['only' => ['index','show']]);
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
         View::share('title', 'Permission');
         View::share('mainModel', new PermissionModel());

         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = Permission::orderBy('id','DESC');


        if(!empty($name)) 
        {
            $items =  $items->where('name', 'like', '%' . $name . '%');
        }
        

        $items =  $items->paginate(10);

        return view('backend.permissions.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.permissions.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =   [
            'name' => 'required|unique:permissions,name',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            //dd($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        }else{


            $permission = Permission::create(['name' => $request->input('name')]);

            
            $permission->status_id = $request->status_id;

            $permission->save();
        
            return redirect('backend/permission')
                            ->with('success','Permission created successfully');
        }

        //dd($request->permission);
    
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Permission::find($id);
        
      
        return view('backend.permissions.edit',compact('model'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules =   [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            $permission = Permission::find($id);
            $permission->name = $request->input('name');
            $permission->status_id = $request->status_id;
            $permission->save();
        
            return redirect('backend/permission')->with('success','Permission updated successfully');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("permissions")->where('id',$id)->delete();
        return redirect('backend/permission')
                        ->with('success','Permission deleted successfully');
    }

    /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
       $item = Permission::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/permission')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/permission')
                        ->with('success','Status Updated successfully');
    }


     /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {

        $request->validate([
            'ids'          => 'required',
        ]);
        
        $ids = $request->ids;


       try {

            //Permission::find(25)->delete();

            $items=Permission::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'Permissions Deleted Successfully']);

        }
        catch(Exception $e) {

         //   dd(2);
         return response(['message' => $e->getMessage()]);

        }

       

    }


}