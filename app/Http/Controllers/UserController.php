<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Record;
use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Redirect;
    use DB;
    use Exception;
    use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:user-edit|user-list|user-create|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
         View::share('title', 'Student');
         View::share('mainModel', new User());

         
    }


    public function dashboard(){
        $student = User::whereHas('roles', function($query) {
            $query->where('name','Student');
        })->where('status_id',1);
        $inquiryC = User::whereHas('roles', function($query) {
            $query->where('name','Student');
        })->where('status_id',0)->count();

        $studentC= $student->count();

        $today = date("Y-m-d");

        $items = User::whereHas('roles', function($query) {
            $query->where('name','Student');
        })->whereHas('fee', function($query) use ($today) {
            // $query->where('due_date','!=',NULL);
            $query->whereDate('due_date','>=',$today);
        })->where('status_id',1)->orderBy(
            Fee::select('due_Date') 
            ->whereColumn('fees.user_id','users.id')
            ->take(1),'asc'
          )->paginate(10);

        $recordC = Record::count();


        return view('backend.dashboard',compact('studentC','inquiryC','recordC','items'));

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = User::whereHas('roles', function($query) {
             $query->where('name','Student');
         })->where('status_id',1)->orderBy('id','DESC');


        if(!empty($name)) 
        {
            $items =  $items->where(function ($query) use ($name) {
                $query->where('name', 'Ilike', '%' . $name . '%')
                      ->orWhere('created_at', 'Ilike', '%' . $name . '%')
                      ->orWhere('type_id', 'Ilike', '%' . $name . '%');
            });

           
        }
        

        $items =  $items->paginate(10);

        return view('backend.students.index',compact('items','name'));
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.students.create');
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
            'name' => 'required',
      

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{
            $data = $request->all();
            $data['email'] = $request->name.rand()."@gmail.com";
            $data['password'] = Hash::make('12345678');
            $data['status_id'] = 1;

               // dd($data);

            try{
               

                if($request->hasFile('profile_photo')) {
                    $icon = date('Ymd') . '_' . time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
                    $request->profile_photo->move(public_path('uploads'), $icon);
                    $data['profile_photo']= $icon;

                }

                $user = User::create($data);

                if(!empty($request->roles))
                {
    
                    // dd($request->roles);
                $user->assignRole($request->input('roles'));
                }

                return redirect('backend/user')
                ->with('success','User created successfully');
            }
            catch(Exception $e){
                return redirect()->back()->with('error',$e->getMessage());
                
            }
          
        
           
        }

    
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $user = User::where('id', $id)->first();

        $userRole = $user->roles->pluck('name','name')->all();

       
        
      
        return view('backend.students.edit',compact('model','userRole','roles'));
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


           // dd($request->all());

            try{
                $data = $request->all();
                $user = User::find($id);
                $user->update($data);

              
                if(!empty($request->password)){
                    $user->password = Hash::make($request->password);
                }
                if($request->hasFile('profile_photo')) {
                    $icon = date('Ymd') . '_' . time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
                    $request->profile_photo->move(public_path('uploads'), $icon);
                    $user->profile_photo = $icon;
                }

                $user->save();
                return redirect('backend/user')->with('success','User updated successfully');
            }
            catch(Exception $e){
                return redirect('backend/user')
                ->with('error',$e->getMessage());
            }
          

        
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
        DB::table("users")->where('id',$id)->delete();
        return redirect('backend/user')
                        ->with('success','User deleted successfully');
    }

    /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
       $item = User::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/user')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/user')
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
            $items=User::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'Users Deleted Successfully']);

        }
        catch(Exception $e) {
         return response(['message' => $e->getMessage()]);
        }
    }

     /**
     * update own profile
     *
     * @return \Illuminate\Http\Response
     */


    public function myProfile(){
        $model = Auth::user();
        return view('backend.students.profile',[
            'model' => $model,
        ]);
    }

    public function changePassword()
    {
        $model = Auth::user();

        return view('backend.students.change-password',[
            'model' => $model,
        ]);

    }

    public function updatePassword(Request $request)
    {
        $rules =   [
            'password' =>  [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],
            'new_password' => 'required',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{


           // dd($request->all());

            try{
                $data = $request->all();
                $user = User::find(Auth::id());

              
                if(!empty($request->password)){
                    $user->password = Hash::make($request->new_password);
                }
             
                $user->save();
                return redirect()->back()->with('success','Password changed successfully');
            }
            catch(Exception $e){
                return redirect()->back()
                ->with('error',$e->getMessage());
            }
          

        
        }
    }

}