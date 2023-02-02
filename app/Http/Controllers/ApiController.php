<?php
    
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Redirect;
    use DB;
    use Exception;
    use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class ApiController extends Controller
{
    

    public   $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiODg4MjE3MTY3NSJ9.X22AvgGujfGXBT5XAiD46kSwzRdyw9kfgJ9kXTRZc49'; // TRUE or FALSE
    public   $url  = "https://justforpay.in/production/testapi/dmt_request";



    public function webhock(){
        echo $tz = Carbon::now()->addHour();
        echo "<br/>";
        $local='04:06 AM';
        echo $emitted = Carbon::parse($local);
        echo "<br/>";
        echo $diff = $emitted->diffForHumans(now()->addHour()); 
    }
    
    public function contactForm(Request $request)
    {
        $data = $request->all();
        $data['email'] = $request->name.rand()."@gmail.com";
        $data['password'] = Hash::make('12345678');

       // dd($data);

    try{
       

        

        $user = User::create($data);

       
        $user->assignRole('Student');
        
        return response()->json('success', 200);        

      
    }
    catch(Exception $e){
        return response()->json($e->getMessage(), 400);        
    }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBeneficiary(Request $request)
    {

        
        try {

            $data =   [
                "api_key" => $this->token,
                "mobile" => "9582639732", 
                "action" => "get_all_beneficiary" 
             ]; 
              
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
    }


     /**
     * create new benficiary.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBeneficiary(Request $request)
    {

        try {

            $data =  [
                "action" => "add_beneficiary", 
                "api_key" => $this->token, 
                "name" => "Aman Raj", 
                "bank_account" => "0626010198868", 
                "mobile_n" => "8080671650", 
                "channel" => "IMPS", 
                "ifsc_code" => "UCBA0001241", 
                "bank_name" => "UCO BANK", 
                "mobile" => "7021339459", 
                "orderId" => "594318959", 
                "email" => "test@demo.com", 
                "address" => "D 68, Pulpelhadpur South Delhi Delhi", 
                "State" => "Delhi", 
                "city" => "New Delhi", 
                "pincode" => "110020" 
             ]; 
              
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
        
    }


     /**
     * create new benficiary.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetSpecialBeneficiaryRecord (Request $request)
    {

        try {

         $data =   [
                "action" => "getBeneficiary", 
                "api_key" => $this->token, 
                "mobile" => "7021339459", 
                "account_no" => "0626010198868" 
             ]; 
              
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
        
    }



    
     /**
     * delete benficiary.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteBeneficiary(Request $request)
    {

        try {

         $data =   [
            "action" => "removeBeneficiary",
            "api_key" => $this->token, 
            "mobile" => "7021339459", 
            "account_no" => "0626010198868" 
         ]; 
              
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
        
    }

     /**
     *  for verification.
     *
     * @return \Illuminate\Http\Response
     */
    public function accountVerification(Request $request)
    {

        try {

         $data =   [
            "api_key" =>$this->token, 
            "orderId" => "495905905", 
            "mobile_no" => "7303703777", 
            "mobile" => "9582639732", 
            "name" => "Aman Raj", 
            "ifsc_code" => "ICIC0000029", 
            "account_no" => "002901570075", 
            "bank_name" => "ICIC BANK", 
            "amount" => "", 
            "channel" => "IMPS", 
            "action" => "verifyAccount", 
            "email" => "test@demo.com", 
            "address" => "D 68, Pulpelhadpur South Delhi Delhi", 
            "state" => "Delhi", 
            "city" => "New Delhi", 
            "pincode" => "110020" 
         ]; 
              
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
        
    }


     /**
     *  for verification.
     *
     * @return \Illuminate\Http\Response
     */
    public function moneyTransfer(Request $request)
    {

        try {

         $data =    [
            "api_key" => $this->token, 
            "orderId" => "095450905949", 
            "mobile_no" => "9769050956", 
            "name" => "Test Name", 
            "mobile" => "9876543210", 
            "ifsc_code" => "ICIC0000029", 
            "account_no" => "002904903049", 
            "action" => "money_transfer", 
            "amount" => "100", 
            "channel" => "IMPS", 
            "email" => "email@gmail.com", 
            "address" => "get address here", 
            "bank_name" => "ICICI BANK", 
            "state" => "DELHI" 
         ]; 
        
            $post_data = json_encode($data);
              
            // Prepare new cURL resource
            $crl = curl_init($this->url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crl, CURLINFO_HEADER_OUT, true);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
              
            // Set HTTP Header for POST request 
            curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json','Authorization: '.$this->token));
              
            // Submit the POST request
            $result = curl_exec($crl);
            $statusCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

            if($statusCode==400){
                $message = 'You are not registor with our service, please connect with our support team for more details';
            }
            elseif($statusCode==402){
                $message= 'Oops! your have send us a duplicate order id please send us it unique
                everytime';
            }
            elseif($statusCode==500){
                $message= 'Internal server error';

            }
            else{
                $message = $result;
            }
            return response()->json($message,$statusCode);
        } catch (\Exception $e) 
        {
            return response()->json($e->getMessage(), 400);
        }
        
    }


    public function testSqlInjection(Request $request)
    {
            dd($request->search_term);
    }
    
   


}