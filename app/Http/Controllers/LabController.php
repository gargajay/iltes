<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\Lab;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Redirect;
    use DB;
    use Exception;
    use Facade\FlareClient\Http\Response;
    use Illuminate\Support\Facades\View;

class LabController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:lab-edit|Lab-list|lab-create|lab-delete', ['only' => ['index','show']]);
         $this->middleware('permission:lab-create', ['only' => ['create','store']]);
         $this->middleware('permission:lab-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:lab-delete', ['only' => ['destroy']]);
         View::share('title', 'Lab');
         View::share('mainModel', new Lab());

         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = Lab::orderBy('id','DESC');


        if(!empty($name)) 
        {
            $items =  $items->where('name', 'like', '%' . $name . '%');
        }
        

        $items =  $items->paginate(10);

        return view('backend.labs.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.labs.create');
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
            'name' => 'required|unique:Labs,name',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            //dd($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            try{
                $Lab = new Lab();
                $Lab->name = $request->name;
                $Lab->status_id = $request->status_id;
                $Lab->user_id = $request->user_id;
                $Lab->address = $request->address;
                $Lab->phone = $request->phone;
                $Lab->email = $request->email;

                $Lab->save();
                return redirect('backend/lab')
                                ->with('success','Lab created successfully');
            }catch(Exception $e)
             {
                return redirect()->back()
                ->with('error',$e->getMessage());
                        }
            
        }

        //dd($request->Lab);
    
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Lab::find($id);
        
      
        return view('backend.labs.edit',compact('model'));
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

            try{
            $Lab = Lab::find($id);
            $Lab->name = $request->input('name');
            $Lab->status_id = $request->status_id;
            $Lab->user_id = $request->user_id;
            $Lab->email = $request->email;
            $Lab->address = $request->address;
            $Lab->phone = $request->phone;
            $Lab->save();
        
            return redirect('backend/lab')->with('success','Lab updated successfully');
            }
            catch(Exception $e)
             {
                return redirect()->back()
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

        try{
            DB::table("Labs")->where('id',$id)->delete();
            return redirect('backend/lab')->with('success','Lab deleted successfully');
           }
        catch(Exception $e)
           {
                return redirect()->back()
                ->with('error',$e->getMessage());
           }
        
      
    }

    /**
     * update status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
       $item = Lab::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/lab')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/lab')
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

            //Lab::find(25)->delete();

            $items=Lab::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'Labs Deleted Successfully']);

        }
        catch(Exception $e) {

         //   dd(2);
         return response(['message' => $e->getMessage()]);

        }

       

    }


}