<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(){
     $user=UserResource::collection(User::paginate());

        return response()->json([
             'success'=>true,
             'data'=>$user,
             'message'=>'user retrived success',

        ]);
    }


public function show($id){

    $user= User::select('id','name','email','mobile','created_at')->find($id);
if($user){
    return response()->json([
        'success'=>true,
        'data'=>$user,
        'message'=>' single user retrived success',

    ]);
}else{
    return response()->json('user not found');
}

}

public function destroy($id){
    $user= User::find($id);
  if($user){
      $user->delete();
      return response()->json([
          'success'=>true,
          'data'=>$user,
          'message'=>' single user delete success',

      ]);
  }else{
      return response()->json([
          'success'=>false,
          'data'=>[],
          'message'=>'user NOt Found',

      ]);
  }
}











   public function otpForm(){
       return view('otp-form');
   }


   public function sendotp(Request $request){

       $otp=rand(1111,9999);
       info("otp:".$otp);
       $user= User::where('mobile',$request->mobile)->update(['otp'=>$otp]);

       $to = "$request->mobile";
       $token = "187dbece62dd1beea422cf8d20d0a6e6";
       $message = "Your varification code is: ".$otp;

       $url = "http://api.greenweb.com.bd/api.php?json";


       $data= array(
           'to'=>"$to",
           'message'=>"$message",
           'token'=>"$token"
       ); // Add parameters in key value
       $ch = curl_init(); // Initialize cURL
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_ENCODING, '');
       curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $smsresult = curl_exec($ch);



       return response()->json($user,200);

   }



   public function sendWithotp(Request $request){

      $user=User::where('mobile',$request->mobile)->where('otp',$request->otp)->first();

      if($user){
           Auth::login($user);
          User::where('mobile',$request->mobile)->update(['otp'=>$request->otp]);
          return redirect()->route('dashboard');
      }else{
            return back();
      }
   }
}
