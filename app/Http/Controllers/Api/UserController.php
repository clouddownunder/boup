<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OtpResource;
use App\Http\Resources\SignIn;
use App\Http\Resources\SignUp;
use Illuminate\Http\Request;
use App\Models\User;


use App\Models\UserPushnotifications;
use App\Models\AvailabilityDrivers;


use App\Models\Otp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\UserProfile;
use Carbon\Carbon;
use App\Mail\RequestOtp;
use App\Mail\WelcomeMail;
use App\Http\Resources\notificationlist;
use App\Mail\Userforgotpassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Storage;






class UserController extends Controller
{
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|max:16',
            'deviceToken' => 'required',
            'deviceType' => 'required|in:' . User::DEVICE_ANDROID . ',' . User::DEVICE_IOS,
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required'
        ], [
            'email.exists' => __('api.email_not_registered')
        ]);
        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $userInfo = User::where('email',$request->email)->first();

        if($userInfo->user_type != 3){
            // check user type, email and password then login :-
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $userid = Auth::user()->id;
    
                $status = $user->status;
                // dd($status);
                if (in_array($status, [User::STATUS_SUSPENDED, User::STATUS_ADMIN_BLOCK] )) {
                    $message = __('api.your_account_is_blocked');
                    if ($status == User::STATUS_SUSPENDED) {
                        $message = __('api.your_account_is_suspended');
                        $suspended_lastdate = \Carbon\Carbon::parse($user->suspend_end_date)->format('d/m/Y');
    
                        $response = [
                            'status' => User::STATUS_BLOCK_SUSPENDED,
                            'message' => $message,
                            'suspended_last_date' => $suspended_lastdate,
                            "server_date" => date('d/m/Y h:i')
                        ];
                        // $user->token()->revoke();
                        return response()->json($response);
                    }
                    $response = [
                        'status' => User::STATUS_BLOCK_SUSPENDED,
                        'message' => $message,
                        "server_date" => date('d/m/Y h:i')
                    ];
                    // $user->token()->revoke();
                    return response()->json($response);
                }
        
                $userData = User::find($userid);
                $userData->device_type = $request->deviceType;
                $userData->device_token = $request->deviceToken;
                $userData->app_version = $request->versionCode;
                $userData->os_version = $request->osVersion;
                $userData->device_name = $request->mobileName;
                $userData->save();
    
                $request->user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });
    
                $userData->accessToken = $user->createToken('authToken')->accessToken;
    
                return self::apiResponse(new SignIn($userData), __('api.login_success'));
            } else {            
                return self::apiError(__('api.email_password_incorrect'));
            }
        }else{
            return self::apiError(__('api.email_password_incorrect'));
        }
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'otp'=> 'required',
            'password' => 'required|min:6|max:16',
            'deviceToken' => 'required',
            'deviceType' => 'required|in:' . User::DEVICE_ANDROID . ',' . User::DEVICE_IOS,
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required'

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $otp = Otp::where([
            'email'=> $request->email,
            'otp' => $request->otp
        ])->first();

        if (!empty($otp)) {
            $otpdelete = Otp::where('email',$request->email)->first();
            $otpdelete->delete();

            $user = new User();
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->device_token = $request->deviceToken;
            $user->device_type = $request->deviceType;
            $user->app_version = $request->versionCode;
            $user->os_version = $request->osVersion;
            $user->device_name = $request->mobileName;
            $user->is_setup_profile = 0;
            $user->save();
    
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
    
                $user->accessToken = $user->createToken('authToken')->accessToken;
    
                return self::apiResponse(new SignUp($user), __('api.register_success'));
            } else {
                return self::apiError(__('api.email_password_incorrect'));
            }
            
            return self::apiResponse(message: __('api.otp_verified'));
        }

        return self::apiError(__('api.invalid_otp'));

    }

    public function logout()
    {

        if (\Auth::user()) {
            $u = Auth::user();
            $u->device_token = "";
            $u->save();
            $user = Auth::user()->token();
            $user->revoke();
        }
        return self::apiResponse(message: __("api.logout_success"));
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'nullable|exists:otps,mobile_no',
            'otp' => 'required',
        ], [
            'mobile.exists' => __('api.mobile_not_registered'),
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $otp = Otp::where([
            'mobile_no'=> $request->mobile,
            'otp' => $request->otp
        ])->first();
        if (!empty($otp)) {
            $otpdelete = Otp::where('mobile_no',$request->mobile)->first();
            $otpdelete->delete();

            return self::apiResponse(message: __('api.otp_verified'));
        }

        return self::apiError(__('api.invalid_otp'));
    }

    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            // 'deviceToken' => 'required',
            'deviceType' => 'required|in:' . User::DEVICE_ANDROID . ',' . User::DEVICE_IOS,

        ]);

        if ($validator->fails()) {  
            return self::apiError($validator->errors()->first());
        }

        $email = $request->email;

        $otp =  mt_rand(1000, 9999);
        $otp=  strval($otp);
        // dd($otp,$email);

        $otp = Otp::updateOrCreate([
            'email'=> $email
        ],['otp' => $otp,'device_type' => $request->deviceType]);

        if (!empty($otp)) {
            Mail::to($email)->send(new RequestOtp($otp));
            return self::apiResponse(new OtpResource($otp), __('api.otp_generated_success'));
        }

        return self::apiError(__('api.unable_generate_otp'));


    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
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
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
     
            $name = ucfirst($user->first_name);
            if(empty($name)){
                $name = "User";
            }

            $token = Str::random(20);
            
            $store =  DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token]
            );
            Mail::to($request->email)->send(new Userforgotpassword($token,$name));

            $userData = User::find($user->id);
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

    public function setUserType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userType' => 'required',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Auth::user();

        if($user->user_type){
            return self::apiError(__('api.usertype_set_already'));
        }else{
            $userInfo = User::find($user->id);
            $userInfo->user_type = $request->userType;
            $userInfo->save();

            return self::apiResponse(message: __('api.usertype_success'));

        }


    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|min:6|max:16',
            'newPassword' => 'required|min:6|max:16',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $user = Auth::user();

        // Match The Old Password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return self::apiError(__('api.old_password_incorrect'));
        } 

        if(strcmp($request->currentPassword, $request->newPassword) == 0){
            //Current password and new password are same
            return self::apiError(__('api.old_password_same_incorrect'));
        }
        
        $userData['password'] = Hash::make($request->newPassword);

        $passwordUpdated = $user->update($userData);
        if ($passwordUpdated) {
            // Mail::to($user->email)->send(new ChangePassword($user));
            return self::apiResponse(message: __('api.password_updated_success'));
        } else {
            return self::apiError(__('api.unable_update_password'));
        }

    }

    public function profileSetup(Request $request){
   
        $user = Auth::user();

        if($user->is_setup_profile == 1){
            return self::apiError(__('api.profile_setup_already'));
        }

        $validator = Validator::make($request->all(), [
            // 'profilePic' => 'mimes:jpeg,jpg,png',
            'userType'=> 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'suburb' => 'required',

            'state' => 'required',
            'industryJourney' => 'required',
            'certificares' => 'required',
            'availabilityDates' => 'required'

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        if($user->email != $request->email){
            return self::apiError(__('api.email_addresss_issue'));
        }

        $imageName = '';
        if($request->file('profilePic')){
            // START: Image store
            $getImage = $request->profilePic;
            $directory = 'profileImg';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $imageName = time() . '.' . $getImage->extension();
            $getImage->storeAs($directory, $imageName, 'public');
    
            // END: Image store  
        }

        $user =  User::find($user->id);
        $user->profile_pic = $imageName;
        $user->profile_pic_thumb = $imageName;
        $user->user_type = $request->userType;
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->mobile_no = $request->mobile;
        $user->gender = $request->gender;
        $user->suburb = $request->suburb;
        $user->interested_state = $request->state;
        $user->save();

        // Industry Experience :-
        $industryJourney = $request->industryJourney;
        // $industryJourney = json_decode($request->industryJourney, true);

        foreach ($industryJourney as $industryJourneyData) {

            $user->industry_experience()->create([
                'industry_name' => $industryJourneyData['industryName'],
                'experienced_year'  => $industryJourneyData['years'],
                'experienced_month' => $industryJourneyData['month'],
                'current_worked' => $industryJourneyData['isWorking'],
                'user_id' => $user->id
            ]);
        }


        // Certificate Add :-

        $certificares = $request->certificares;

        foreach ($certificares as $index => $certificaresData) {

            if($certificaresData['otherCertificareName']){
                // dd("Data");
                // $expireDate = date('Y-m-d', strtotime($certificaresData['expireDate']));

                // //START: Image and doc store
                // // $getImage = $certificares->certificateFile;
                // // $getImage = $request->file("certificares.$index.certificateFile");
                // $getImage = $request->certificateFile[$index];
                // // dd($getImage);

                // $directory = 'Certificares';
                // if (!Storage::disk('public')->exists($directory)) {
                //     Storage::disk('public')->makeDirectory($directory);
                // }
                // $imageName = time() . '_' . uniqid() . '.' . $getImage->extension();
                // $getImage->storeAs($directory, $imageName, 'public');
                // // END: Image and doc store

                $user->certification_details()->create([
                    'user_id' => $user->id,
                    'certification_subname' => $certificaresData['otherCertificareName'],
                    // 'certification_doc'  => $imageName,
                    // 'expired_date' => $expireDate,
                ]);


            }else{

                $expireDate = date('Y-m-d', strtotime($certificaresData['expireDate']));

                //START: Image and doc store
                $getImage = $certificaresData['certificateFile'];
                // $getImage = $request->file("certificares.$index.certificateFile");
                // $getImage = $request->certificateFile[$index];
                // dd($getImage);

                $directory = 'Certificares';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                $imageName = time() . '_' . uniqid() . '.' . $getImage->extension();
                $getImage->storeAs($directory, $imageName, 'public');
                // END: Image and doc store

                $user->certification_details()->create([
                    'user_id' => $user->id,
                    'certification_name' => $certificaresData['certificareType'],
                    'certification_doc'  => $imageName,
                    'expired_date' => $expireDate,
                ]);

            }

        }

        // Availability Dates Management :
        $availabilityDates = json_decode($request->availabilityDates, true);

        $newDates = collect($availabilityDates)->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->unique();


        $currentDates = AvailabilityDrivers::where('user_id', Auth::id())
            ->pluck('available_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));

        $toInsert = $newDates->diff($currentDates);
        foreach ($toInsert as $date) {
            AvailabilityDrivers::create([
                'user_id' => Auth::id(),
                'available_date' => $date,
            ]);
        }

        $toDelete = $currentDates->diff($newDates);
        AvailabilityDrivers::where('user_id', Auth::id())
            ->whereIn('available_date', $toDelete)
            ->delete();

        $user =  User::find($user->id);
        $user->is_setup_profile = 1;
        $user->save();

        Mail::to($request->email)->send(new WelcomeMail($request->firstName));
        
        return self::apiResponse(new UserProfile($user), __('api.profile_success'));

    }

    public function editprofile(Request $request)
    {
        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'profilePic' => 'mimes:jpeg,jpg,png',
            'firstName' => 'required',
            'lastName' => 'required',
            'userType' => 'required',
            'gender'=> 'required',
            'mobile'=>'required',
            'email'=>'required',
            'suburb'=>'required',

        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        if($request->file('profilePic')){
            // START: Image store
            $getImage = $request->profilePic;
            $directory = 'profileImg';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $imageName = time() . '.' . $getImage->extension();
            $getImage->storeAs($directory, $imageName, 'public');
            // END: Image store  
        }

        $user =  User::find($userId);
        if($request->file('profilePic')){ // Image come then stor
            $user->profile_pic = $imageName;
            $user->profile_pic_thumb = $imageName;
        }
        $user->user_type = $request->userType;
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->mobile_no = $request->mobile;
        $user->gender = $request->gender;
        $user->suburb = $request->suburb;
        $user->save();

        return self::apiResponse(new UserProfile($user), __('api.profile_update'));
    }

    public function destroy(Request $request)
    { 
        $validator = Validator::make($request->all(), [  
            'email' => 'required',
            'password' => 'required|min:6|max:16',
        ]);
        
        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        
        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return self::apiError(__('api.password_incorrect'));
        } else {
            if ($request->email === $user->email) {
                $userdel = User::where('id',$user->id)->delete();
                
                return response()->json([
                    'status' => User::STATUS_DELETEUSER,
                    'message' => __("api.account_delete_success"),
                ]);
                
            }else{
                return self::apiError(__('api.email_incorrect'));
            }
        }

    }

    public function setMembership(Request $request){
        // dd($request->all(),Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'subscriptionType' => 'required',
            'orderId' => 'required',
            'productId' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'deviceType' => 'required',
            'appVersion' => 'required',
            'osVersion' => 'required',
            'deviceName' => 'required'
        ]);

        if ($validator->fails()) {
                return self::apiError($validator->errors()->first());
        }
        
        $sdate=$request->startDate;
        $sdate = str_replace('/', '-', $sdate);
        $startdate = date('Y-m-d H:i', strtotime($sdate));

        $edate=$request->endDate;
        $edate = str_replace('/', '-', $edate);
        $enddate = date('Y-m-d H:i', strtotime($edate));
        
        $chk = User::where('id', Auth::user()->id)->first();

        if($chk->user_type == 2){
            // $subscription = new UserSubscription();
            // $subscription->orderId = $request->orderId;
            // $subscription->productId = $request->productId;
            // $subscription->start_date = $startdate;
            // $subscription->end_date = $enddate;
            // $subscription->subscription_type = $request->subscriptionType;
            // $subscription->user_details_id = Auth::user()->id;
            // $subscription->device_type = $request->deviceType;
            // $subscription->app_version = $request->appVersion;
            // $subscription->os_version = $request->osVersion;
            // $subscription->device_name = $request->deviceName;
            // $subscription->save();
            // if ($subscription){
            //     $userchange = User::where('id', Auth::user()->id)
            //     ->update(['subscription_type' => $request->subscriptionType]);
    
            //     return self::apiResponse(new SubscriptionResource($subscription), __('api.subscription_success'));
            // }else {
            //     return self::apiError(__('api.subscription_error'));
            // }
        }

    }

    public function getnotification(Request $request){
        $user = Auth::user()->id;
        
        $page = 10; 
        $notification = UserPushnotifications::where('user_id',$user)->skip($request->pageIndex * $page)->take($page)->orderBy('id', 'DESC')->get();
        
        return self::apiResponse(notificationlist::collection($notification), __("api.notificationlist_success"));
    }


    public function getNotificationList(Request $request){
        $user = Auth::user()->id;
        // $page = 10; 
        $notification = NotificationHistory::where('user_id',$user)->orderBy('id', 'DESC')->get();
        // dd($notification);
        NotificationHistory::where('user_id', $user)->update(['is_read' => 0]);
        
        return self::apiResponse(notificationlist::collection($notification), __("api.notificationlist_success"));
    }

    public function getnotificationCount(){
        $user = Auth::user()->id;
        $notification = NotificationHistory::where(['user_id'=>$user,'is_read'=> '1'])->count();
        // dd($notification);
        if($notification == 0){
            $isRead = 0;
        }else{
            $isRead = 1;
        }

        return response()->json([
            'status' => 1,
            'message' => __("api.notificationlist_success"),
            'data' => [ 'isRead'=> $isRead],
        ]);
    }


    /**
     * Function will mark notification as read
     *
     * @return void
     */

}
