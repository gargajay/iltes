<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\TestCategory;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Redirect;
    use DB;
    use Exception;
    use Facade\FlareClient\Http\Response;
    use Illuminate\Support\Facades\View;

class TestCategoryController extends Controller
{
    

    function __construct()
    {
         $this->middleware('permission:testCategory-edit|testCategory-list|testCategory-create|testCategory-delete', ['only' => ['index','show']]);
         $this->middleware('permission:testCategory-create', ['only' => ['create','store']]);
         $this->middleware('permission:testCategory-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:testCategory-delete', ['only' => ['destroy']]);
         View::share('title', 'TestCategory');
         View::share('mainModel', new TestCategory());

         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');


        $items = TestCategory::orderBy('id','DESC');


        if(!empty($name)) 
        {
            $items =  $items->where('name', 'like', '%' . $name . '%');
        }
        

        $items =  $items->paginate(10);

        return view('backend.testCategorys.index',compact('items','name'));
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.testCategorys.create');
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
            'name' => 'required|unique:test_categories,name',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            //dd($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            try{
                $TestCategory = new TestCategory();
                $TestCategory->name = $request->name;
                $TestCategory->status_id = $request->status_id;
                $TestCategory->lab_id = $request->lab_id;

            

                $TestCategory->save();
                return redirect('backend/testCategory')
                                ->with('success','TestCategory created successfully');
            }catch(Exception $e)
             {
                return redirect()->back()
                ->with('error',$e->getMessage());
                        }
            
        }

        //dd($request->TestCategory);
    
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = TestCategory::find($id);
        
      
        return view('backend.testCategorys.edit',compact('model'));
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
        // dd($request->all());
        $rules =   [
            'name' => 'required|unique:test_categories,name,'.$id,
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator);
        }else{

            try{
            $TestCategory = TestCategory::find($id);
            $TestCategory->name = $request->input('name');
            $TestCategory->status_id = $request->status_id;
            $TestCategory->lab_id = $request->lab_id;
            
            $TestCategory->save();
        
            return redirect('backend/testCategory')->with('success','TestCategory updated successfully');
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
            DB::table("testCategorys")->where('id',$id)->delete();
            return redirect('backend/testCategory')->with('success','TestCategory deleted successfully');
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
       $item = TestCategory::where('id',$id)->first();

       if(empty($item)){
        return redirect('backend/testCategory')
        ->with('error','Record not Found !');
       }
       
       $item->status_id = $status;
       $item->save();

        return redirect('backend/testCategory')
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

            //TestCategory::find(25)->delete();

            $items=TestCategory::find($ids)->each(function ($product, $key) {
                $product->delete();
                });
            return response(['message' => 'testCategorys Deleted Successfully']);

        }
        catch(Exception $e) {

         //   dd(2);
         return response(['message' => $e->getMessage()]);

        }

       

    }


}