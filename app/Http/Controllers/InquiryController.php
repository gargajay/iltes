<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
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

class InquiryController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:inquiry-edit|inquiry-list|inquiry-create|inquiry-delete', ['only' => ['index','show']]);
         $this->middleware('permission:inquiry-create', ['only' => ['create','store']]);
         $this->middleware('permission:inquiry-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inquiry-delete', ['only' => ['destroy']]);
         View::share('title', 'Inquiry');
         View::share('mainModel', new User());

         
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
        })->where('status_id',User::STATUS_INQUIRY)->orderBy('id','DESC');


        if(!empty($name)) 
        {
            
            $items =  $items->where(function ($query) use ($name) {
                $query->where('name', 'ilike', '%' . $name . '%')
                      ->orWhere('created_at', 'ilike', '%' . $name . '%')
                      ->orWhere('type_id', 'ilike', '%' . $name . '%');
            });
            
        }
        

        $items =  $items->paginate(10);

        return view('backend.inquirys.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.inquirys.create');
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
    
                $user->assignRole($request->input('roles'));
                }

                return redirect('backend/inquiry')
                ->with('success','Inquiry created successfully');
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

       
        
      
        return view('backend.inquirys.edit',compact('model','userRole','roles'));
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
            'profile_photo' => 'image|mimes:jpeg,png,jpg|max:10000',

                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{

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

                
            
                return redirect('backend/inquiry')->with('success','Inquiry updated successfully');
            }
            catch(Exception $e){
                return redirect('backend/inquiry')
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
        return redirect('backend/inquiry')
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
        return redirect('backend/inquiry')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/inquiry')
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
            return response(['message' => 'inquirys Deleted Successfully']);

        }
        catch(Exception $e) {
         return response(['message' => $e->getMessage()]);
        }
    }

    


}