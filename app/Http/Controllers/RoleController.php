<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\RoleModel;
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
    use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    

    function __construct()
    {
        $this->middleware('permission:role-edit|role-list|role-create|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
         View::share('title', 'Role');
         View::share('mainModel', new RoleModel());

         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = RoleModel::orderBy('id','DESC');


        if(!empty($name)) 
        {
            $items =  $items->where('name', 'like', '%' . $name . '%');
        }
        

        $items =  $items->paginate(10);

        return view('backend.roles.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolePermissions = []; 
        $permission = Permission::orderBy('order_index','asc')->get();
        return view('backend.roles.create',compact('permission','rolePermissions'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            //dd($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        }else{


            try{
                $role = Role::create(['name' => $request->input('name')]);

            
                $role->syncPermissions($request->input('permission'));
                $role->status_id = $request->status_id;
    
                $role->save();
            
                return redirect('backend/role')
                                ->with('success','Role created successfully');
            }catch(Exception $e) {
                return redirect('backend/role')
                ->with('error',$e->getMessage());
            }   

           
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
        $model = RoleModel::find($id);
        $permission = Permission::orderBy('order_index','asc')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
      
        return view('backend.roles.edit',compact('model','permission','rolePermissions'));
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
             'permission' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            //dd($validator);
            return Redirect::back()->with('error','Please choose at least one permission');
        }else{

            $role = RoleModel::find($id);
            $role->name = $request->input('name');
            $role->save();
        
            $role->syncPermissions($request->input('permission'));

            $role->status_id = $request->status_id;

            $role->save();

        
            return redirect('backend/role')->with('success','Role updated successfully');
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
        DB::table("roles")->where('id',$id)->delete();
        return redirect('backend/role')
                        ->with('success','Role deleted successfully');
    }

    /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
       $item = Role::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/role')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/role')
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

            //Role::find(25)->delete();

            $items=Role::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'Roles Deleted Successfully']);

        }
        catch(Exception $e) {

         //   dd(2);
         return response(['message' => $e->getMessage()]);

        }

       

    }


}