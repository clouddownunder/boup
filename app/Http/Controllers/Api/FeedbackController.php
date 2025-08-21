<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class FeedbackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'experience' => 'required',
            'feature' => 'required',
            'deviceType' => 'required',
            'versionCode' => 'required',
            'osVersion' => 'required',
            'mobileName' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $user = Auth::user();
        $date = Carbon::now();
        // dd($request->all(),$user);
        
        $feedback = new Feedback();
        $feedback->experience = $request->experience;
        $feedback->suggestion = $request->feature;
        $feedback->feedback_date = $date;
        $feedback->user_id	= $user->id;
        $feedback->app_version = $request->versionCode;
        $feedback->os_version = $request->osVersion;
        $feedback->device_type = $request->deviceType;
        $feedback->device_name = $request->mobileName;
        $feedback->save();
        
        if ($feedback){
            return self::apiResponse(message: __('api.feedback_success'));
        } else {
            return self::apiError(__('api.unable_to_send_feedback'));
        }

    }
}
