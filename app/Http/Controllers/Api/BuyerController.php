<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerFaq;
use App\Http\Resources\BuyersInfo;
use App\Mail\ChangePassword;
use App\Mail\Userforgotpassword;
use App\Mail\WelcomeMail;
use App\Models\About;
use App\Models\BuyerAccount;
use App\Models\Buyers;
use App\Models\BuyersFAQ;
use Google\Service\AdExchangeBuyerII\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BuyerController extends Controller
{
    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:buyers,email',
            'password' => 'required|min:6|max:16',
            'deviceToken' => 'required',
            'deviceType' => 'required',
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required'

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $buyerData = Buyers::where('email',$request->email)->first();

        if(!$buyerData){

            $user = new Buyers();
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->device_token = $request->deviceToken;
            $user->device_type = $request->deviceType;
            $user->app_version = $request->versionCode;
            $user->os_version = $request->osVersion;
            $user->device_name = $request->mobileName;
            $user->is_setup_profile = 0;
            $user->save();

            $user->accessToken = $user->createToken('authToken')->accessToken;

            return self::apiResponse(new BuyersInfo($user), __('api.register_success'));
        } else {
            return self::apiError(__('api.email_already_registered'));
        }
            

    }

    public function signIn(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:buyers,email',
            'password' => 'required|min:6|max:16',
            'deviceToken' => 'required',
            'deviceType' => 'required',
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required'
        ], [
            'email.exists' => __('api.email_not_registered')
        ]);
        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        // dd($request->all());
        $userInfo = Buyers::where('email',$request->email)->first();

        if (!$userInfo || !Hash::check($request->password, $userInfo->password)) {
            return self::apiError(__('api.email_password_incorrect'));
        }

        $userData = Buyers::find($userInfo->id);
        $userData->device_type = $request->deviceType;
        $userData->device_token = $request->deviceToken;
        $userData->app_version = $request->versionCode;
        $userData->os_version = $request->osVersion;
        $userData->device_name = $request->mobileName;
        $userData->save();

        $userData->tokens()->delete();

        $userData->accessToken = $userData->createToken('authToken')->accessToken;
        return self::apiResponse(new BuyersInfo($userData), __('api.login_success'));


    }

    public function logout()
    {

        if (\Auth::guard('buyer')->user()) {
            $u = Auth::guard('buyer')->user();
            $u->device_token = "";
            $u->save();
            $user = Auth::guard('buyer')->user()->token();
            $user->revoke();

        }
        return self::apiResponse(message: __("api.logout_success"));
    }

    public function setupProfile(Request $request){
        // dd("setupProfile");
        $buyer = Auth::guard('buyer')->user();

        if($buyer->is_setup_profile == 1){
            return self::apiError(__('api.profile_setup_already'));
        }
        

        $validator = Validator::make($request->all(), [
            'fullName'=> 'required',
            'dob' => 'required',
            'mailAddressStreet' => 'required',
            'mailAddressCity' => 'required',
            'mailAddressState' => 'required',
            'mailAddressPostcode' => 'required',
            'shippingAddressStreet' => 'required',
            'shippingAddressCity' => 'required',
            'shippingAddressState' => 'required',
            'shippingAddressPostcode' => 'required',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        
        $user = Buyers::find($buyer->id);
        $user->name = $request->fullName;
        $user->dob = $request->dob;
        $user->mailing_address = $request->mailAddressStreet;
        $user->mailing_suburb = $request->mailAddressCity;
        $user->mailing_state = $request->mailAddressState;
        $user->mailing_postcode = $request->mailAddressPostcode;
        $user->delivery_address = $request->shippingAddressStreet;
        $user->delivery_suburb = $request->shippingAddressCity;
        $user->delivery_state = $request->shippingAddressState;
        $user->delivery_postcode = $request->shippingAddressPostcode;
        $user->is_setup_profile = 1;
        $user->save();

        // Mail::to($buyer->email)->send(new WelcomeMail($request->fullName));
        
        return self::apiResponse(new BuyersInfo($user), __('api.profile_success'));
    }

    public function editProfile(Request $request){

        $buyer = Auth::guard('buyer')->user();

        $validator = Validator::make($request->all(), [
            'fullName'=> 'required',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Buyers::find($buyer->id);
        $user->name = $request->fullName;
        $user->dob = $request->dob;
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => __("api.profile_update")
        ]);

    }

    public function editAddress(Request $request){

        $buyer = Auth::guard('buyer')->user();

        $validator = Validator::make($request->all(), [
            'mailAddressStreet' => 'required',
            'mailAddressCity' => 'required',
            'mailAddressState' => 'required',
            'mailAddressPostcode' => 'required',
            'shippingAddressStreet' => 'required',
            'shippingAddressCity' => 'required',
            'shippingAddressState' => 'required',
            'shippingAddressPostcode' => 'required',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Buyers::find($buyer->id);
        $user->mailing_address = $request->mailAddressStreet;
        $user->mailing_suburb = $request->mailAddressCity;
        $user->mailing_state = $request->mailAddressState;
        $user->mailing_postcode = $request->mailAddressPostcode;
        $user->delivery_address = $request->shippingAddressStreet;
        $user->delivery_suburb = $request->shippingAddressCity;
        $user->delivery_state = $request->shippingAddressState;
        $user->delivery_postcode = $request->shippingAddressPostcode;
        $user->save();
        
        return response()->json([
            'status' => 1,
            'message' => __("api.address_update")
        ]);
    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|min:6|max:16',
            'newPassword' => 'required|min:6|max:16',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $buyer = Auth::guard('buyer')->user();

        // Match The Old Password
        if (!Hash::check($request->currentPassword, $buyer->password)) {
            return self::apiError(__('api.old_password_incorrect'));
        } 

        if(strcmp($request->currentPassword, $request->newPassword) == 0){
            //Current password and new password are same
            return self::apiError(__('api.old_password_same_incorrect'));
        }

        $userData['password'] = Hash::make($request->newPassword);

        $passwordUpdated = $buyer->update($userData);

        if ($passwordUpdated) {
            // Mail::to($buyer->email)->send(new ChangePassword($buyer));
            return self::apiResponse(message: __('api.password_updated_success'));
        } else {
            return self::apiError(__('api.unable_update_password'));
        }
    }

    public function forgetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:buyers,email',
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName'=> 'required',
            'deviceType' => 'required',
            'deviceToken' => 'required'
        ], [
            'email.exists' => __('api.email_not_registered'),
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $buyer = Buyers::where('email', $request->email)->first();

        if (!empty($buyer)) {
     
            $name = ucfirst($buyer->name);
            if(empty($name)){
                $name = "User";
            }

            $token = Str::random(20);
            
            $store =  DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token]
            );
            Mail::to($request->email)->send(new Userforgotpassword($token,$name));

            $userData = Buyers::find($buyer->id);
            $userData->device_type = $request->deviceType;
            $userData->device_token = $request->deviceToken;
            $userData->app_version = $request->versionCode;
            $userData->os_version = $request->osVersion;
            $userData->device_name = $request->mobileName;
            $userData->save();

            return self::apiResponse(message: __('api.email_sent_to_email_success'));
        } else {
            return self::apiError(__('api.email_password_not_match'));
        }
    }


    public function destroy(Request $request)
    { 
        $validator = Validator::make($request->all(), [  
            'reason' => 'required',
            'password' => 'required|min:6|max:16',
        ]);
        
        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        
        $buyer = Auth::guard('buyer')->user();

        if (!Hash::check($request->password, $buyer->password)) {

            return self::apiError(__('api.password_incorrect'));
        } else {
            $deleteInfo = new BuyerAccount();
            $deleteInfo->buyer_id = $buyer->id;
            $deleteInfo->name = $buyer->name;
            $deleteInfo->email = $buyer->email;
            $deleteInfo->reason = $request->reason;
            $deleteInfo->save();

            $userdel = Buyers::where('id',$buyer->id)->delete();

            return self::apiResponse(message: __("api.account_delete_success"));
        }

    }


    public function getfaq(){

        $buyerFaq = BuyersFAQ::orderBy('id', 'DESC')->get();
        
        return self::apiResponse(BuyerFaq::collection($buyerFaq), __("api.faq_success"));
    }

    public function about(){

        $about = About::orderBy('id', 'DESC')->first();

        if($about){
            return response()->json([
                'status' => 1,
                'message' => __("api.about_success"),
                'data' => [ 'about'=> $about->data],
            ]);
        }else{
            return response()->json([
                'status' => 1,
                'message' => __("api.about_success"),
                'data' => [ 'about'=> ''],
            ]);
        }
    }

}

