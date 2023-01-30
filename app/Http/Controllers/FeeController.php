<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\Fee;
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

class FeeController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:fee-edit|fee-list|fee-create|fee-delete', ['only' => ['index','show']]);
         $this->middleware('permission:fee-create', ['only' => ['create','store']]);
         $this->middleware('permission:fee-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:fee-delete', ['only' => ['destroy']]);
         View::share('title', 'Fee');
         View::share('mainModel', new Fee());

         
    }

     /**
     * Display a listing of all the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $name = $request->query('name');

        $user_id = $request->id ?? 0;


        $user = User::find($user_id);
        $items = Fee::with('user')->orderBy('id','DESC');


        if(!empty($name)) 
        {
            
            $items =  $items->where(function ($query) use ($name) {
                $query->where('month', 'like', '%' . $name . '%')
                      ->orWhere('created_at', 'like', '%' . $name . '%')
                      ->orWhere('year', 'like', '%' . $name . '%')
                      ->orWhere('amount', 'like', '%' . $name . '%');
            });
            
        }
        
       // $totalfee = $items->sum('amount');

        $items =  $items->paginate(10);

        return view('backend.fees.all',compact('items'));
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');

        $user_id = $request->id ?? 0;


        $user = User::find($user_id);
        $items = Fee::where('user_id',$request->id)->orderBy('id','DESC');


        if(!empty($name)) 
        {
            
            $items =  $items->where(function ($query) use ($name) {
                $query->where('month', 'like', '%' . $name . '%')
                      ->orWhere('created_at', 'like', '%' . $name . '%')
                      ->orWhere('year', 'like', '%' . $name . '%')
                      ->orWhere('amount', 'like', '%' . $name . '%');
            });
            
        }
        
        $totalfee = $items->sum('amount');

        $items =  $items->paginate(10);

        return view('backend.fees.index',compact('items','name','user_id','user','totalfee'));
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->id;
        return view('backend.fees.create',compact('user_id'));
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
            'month' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{
                $data = $request->all();

                //dd($data);
            try{
                 $user = Fee::create($data);
                 return redirect('backend/fee?id='.$request->user_id)
                ->with('success','fee created successfully');
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
    public function edit(Request $request,$id)
    {
        $user_id = $request->user_id ?? 0;
        $model = Fee::find($id);
       

      
       
        
      
        return view('backend.fees.edit',compact('model','user_id'));
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
            'month' => 'required',

                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            try{
                $data = $request->all();
                $user = Fee::find($id);
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

                
            
                return redirect('backend/fee?id='.$request->user_id)->with('success','fee updated successfully');
            }
            catch(Exception $e){
                return redirect('backend/fee?id='.$request->user_id)
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
    public function destroy(Request $request,$id)
    {
        $user_id= $request->user_id??0;
        DB::table("fees")->where('id',$id)->delete();
        return redirect('backend/fee?id='.$user_id)
                        ->with('success','Fee deleted successfully');
    }

    /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request,$id,$status)
    {
       $item = Fee::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/fee')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/fee')
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
            $items=Fee::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'fees Deleted Successfully']);

        }
        catch(Exception $e) {
         return response(['message' => $e->getMessage()]);
        }
    }

    


}