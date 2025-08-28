<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorFaq;
use App\Http\Resources\VendorInfo;
use App\Mail\ChangePassword;
use App\Mail\Userforgotpassword;
use App\Mail\Vendorforgotpassword;
use App\Models\VendorDeleteAccount;
use App\Models\Vendors;
use App\Models\VendorsFAQ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|min:6|max:16',
            'deviceToken' => 'required',
            'deviceType' => 'required',
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required',

            'contactName' => 'required',
            'phoneNumber' => 'required',
            'buisnessName' => 'required',
            'abn' => 'required',
            'lln' => 'required',
            'streetAddress1' => 'required',
            'streetAddress2' => 'required',
            'suburb' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'message' => 'required',
            'signature' => 'required',
        ]);       

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $vendorData = Vendors::where('email',$request->email)->first();

        if(!$vendorData){

            $user = new Vendors();
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->contact_name	 = $request->contactName;
            $user->phone_no = $request->phoneNumber;
            $user->business_name = $request->buisnessName;
            $user->abn = $request->abn;
            $user->liquor_licence_no = $request->lln;
            $user->street_address1 = $request->streetAddress1;
            $user->street_address2 = $request->streetAddress2;
            $user->suburb = $request->suburb;
            $user->state = $request->state;
            $user->postcode = $request->postcode;
            $user->notes = $request->message;
            $user->sign_image = $request->signature;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->status = 0;


            $user->mailing_address = $request->streetAddress1;
            $user->mailing_suburb = $request->suburb;
            $user->mailing_state = $request->state;
            $user->mailing_postcode = $request->postcode;
            $user->mailing_latitude = $request->latitude;
            $user->mailing_longitude = $request->longitude;

            $user->device_token = $request->deviceToken;
            $user->device_type = $request->deviceType;
            $user->app_version = $request->versionCode;
            $user->os_version = $request->osVersion;
            $user->device_name = $request->mobileName;
            $user->is_setup_profile = 0;
            $user->save();

            $user->accessToken = $user->createToken('authToken')->accessToken;

            return self::apiResponse(new VendorInfo($user), __('api.register_success'));
        } else {
            return self::apiError(__('api.email_already_registered'));
        }
            

    }
    
    public function signIn(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:vendors,email',
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

        $userInfo = Vendors::where('email',$request->email)->first();
        // dd($userInfo);

        if (!$userInfo || !Hash::check($request->password, $userInfo->password)) {
            return self::apiError(__('api.email_password_incorrect'));
        }

        $userData = Vendors::find($userInfo->id);
        $userData->device_type = $request->deviceType;
        $userData->device_token = $request->deviceToken;
        $userData->app_version = $request->versionCode;
        $userData->os_version = $request->osVersion;
        $userData->device_name = $request->mobileName;
        $userData->save();

        $userData->tokens()->delete();

        $userData->accessToken = $userData->createToken('authToken')->accessToken;
        return self::apiResponse(new VendorInfo($userData), __('api.login_success'));


    }
    public function logout()
    {
        if (\Auth::guard('vendor')->user()) {
            $u = Auth::user();
            $u->device_token = "";
            $u->save();
            $user = Auth::guard('vendor')->user()->token();
            $user->revoke();
        }
        return self::apiResponse(message: __("api.logout_success"));
    }

    public function forgetPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:vendors,email',
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

        $vendor = Vendors::where('email', $request->email)->first();

        if (!empty($vendor)) {
     
            $name = ucfirst($vendor->business_name);
            if(empty($name)){
                $name = "User";
            }

            $token = Str::random(20);
            
            $store =  DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token]
            );
            Mail::to($request->email)->send(new Vendorforgotpassword($token,$name));

            $userData = Vendors::find($vendor->id);
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

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|min:6|max:16',
            'newPassword' => 'required|min:6|max:16',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $vendor = Auth::guard('vendor')->user();
        // dd($vendor);

        // Match The Old Password
        if (!Hash::check($request->currentPassword, $vendor->password)) {
            return self::apiError(__('api.old_password_incorrect'));
        } 

        if(strcmp($request->currentPassword, $request->newPassword) == 0){
            //Current password and new password are same
            return self::apiError(__('api.old_password_same_incorrect'));
        }

        $userData['password'] = Hash::make($request->newPassword);

        $passwordUpdated = $vendor->update($userData);

        if ($passwordUpdated) {
            // Mail::to($vendor->email)->send(new ChangePassword($vendor));
            return self::apiResponse(message: __('api.password_updated_success'));
        } else {
            return self::apiError(__('api.unable_update_password'));
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
        // dd("Done");
        $vendor = Auth::guard('vendor')->user();
        // dd($vendor);

        if (!Hash::check($request->password, $vendor->password)) {
            return self::apiError(__('api.password_incorrect'));
        } else {
            $deleteInfo = new VendorDeleteAccount();
            $deleteInfo->vendor_id = $vendor->id;
            $deleteInfo->name = $vendor->business_name;
            $deleteInfo->email = $vendor->email;
            $deleteInfo->reason = $request->reason;
            $deleteInfo->save();

            $userdel = Vendors::where('id',$vendor->id)->delete();

            return self::apiResponse(message: __("api.account_delete_success"));
        }

    }

    public function editProfile(Request $request){
        $vendor = Auth::guard('vendor')->user();

        $validator = Validator::make($request->all(), [
            'fullName'=> 'required',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $dob = Carbon::createFromFormat('d, M Y', $request->dob)->format('Y-m-d');

        $user = Vendors::find($vendor->id);
        $user->name = $request->fullName;
        $user->dob = $dob;
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => __("api.profile_update")
        ]);

    }

    public function businessProfile(Request $request){

        $vendor = Auth::guard('vendor')->user();

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Vendors::find($vendor->id);
        $user->business_name = $request->name;
        $user->website_url = $request->website;
        $user->business_phone_no = $request->phoneNumber;
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => __("api.business_profile_update")
        ]);

    }

    public function businessBranding(Request $request){

        $vendor = Auth::guard('vendor')->user();

        $logo = '';
        $titleImage = '';

        if($request->file('logo')){
            // START: Image store
            $getImage = $request->logo;
            $directory = 'business/logo';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $logo = time() . '.' . $getImage->extension();
            $getImage->storeAs($directory, $logo, 'public');
            // END: Image store  

        }
        if($request->file('titleImage')){
            // START: Image store
            $getImage = $request->titleImage;
            $directory = 'business/titleImage';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $titleImage = time() . '.' . $getImage->extension();
            $getImage->storeAs($directory, $titleImage, 'public');
            // END: Image store  
        }

        $user = Vendors::find($vendor->id);
        if($request->file('logo')){
            $user->logo = $logo;
        }
        if($request->file('titleImage')){
            $user->title_image = $titleImage;
        }
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => __("api.logo_update")
        ]);
    }

    public function editAddress(Request $request){

        $vendor = Auth::guard('vendor')->user();

        $validator = Validator::make($request->all(), [
            'mailAddressStreet' => 'required',
            'mailAddressCity' => 'required',
            'mailAddressState' => 'required',
            'mailAddressPostcode' => 'required',
            'mapAddressStreet' => 'required',
            'mapAddressCity' => 'required',
            'mapAddressState' => 'required',
            'mapAddressPostcode' => 'required',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Vendors::find($vendor->id);
        $user->mailing_address = $request->mailAddressStreet;
        $user->mailing_suburb = $request->mailAddressCity;
        $user->mailing_state = $request->mailAddressState;
        $user->mailing_postcode = $request->mailAddressPostcode;
        $user->map_address = $request->mapAddressStreet;
        $user->map_suburb = $request->mapAddressCity;
        $user->map_state = $request->mapAddressState;
        $user->map_postcode = $request->mapAddressPostcode;
        $user->save();
        
        return response()->json([
            'status' => 1,
            'message' => __("api.address_update")
        ]);
    }

    public function getfaq(){
        
        $vendorFaq = VendorsFAQ::orderBy('id', 'DESC')->get();
        
        return self::apiResponse(VendorFaq::collection($vendorFaq), __("api.faq_success"));
    }

}


