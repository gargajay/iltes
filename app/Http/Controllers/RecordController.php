<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
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

class RecordController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:record-edit|record-list|record-create|record-delete', ['only' => ['index','show']]);
         $this->middleware('permission:record-create', ['only' => ['create','store']]);
         $this->middleware('permission:record-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:record-delete', ['only' => ['destroy']]);
         View::share('title', 'Record');
         View::share('mainModel', new Record());

         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = Record::orderBy('id','DESC');


        if(!empty($name)) 
        {
            
            $items =  $items->where(function ($query) use ($name) {
                $query->where('reading', 'like', '%' . $name . '%')
                      ->orWhere('created_at', 'like', '%' . $name . '%');
            });
            
        }
        

        $items =  $items->paginate(10);

        return view('backend.records.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.records.create');
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
            'user_id' => 'required|unique:records,user_id',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{
                $data = $request->all();
        
            try{

                $user = Record::create($data);

                

                return redirect('backend/record')
                ->with('success','Record created successfully');
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
        $model = Record::find($id);

        return view('backend.records.edit',compact('model'));
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
            'reading' => 'required',

                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            try{
                $data = $request->all();
                $user = Record::find($id);
                $user->update($data);
                $user->save();

                return redirect('backend/record')->with('success','Record updated successfully');
            }
            catch(Exception $e){
                return redirect('backend/record')
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
        DB::table("records")->where('id',$id)->delete();
        return redirect('backend/record')
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
       $item = Record::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/record')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/record')
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
            $items=Record::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'records Deleted Successfully']);

        }
        catch(Exception $e) {
         return response(['message' => $e->getMessage()]);
        }
    }

    


}