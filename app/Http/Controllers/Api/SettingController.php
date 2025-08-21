<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Certificates;
use App\Http\Resources\IndustryExperienceResource;
use App\Http\Resources\JobResource;
use App\Models\AppliedJob;
use App\Models\AvailabilityDrivers;
use App\Models\CertificationDetails;
use App\Models\IndustryExperience;
use App\Models\Jobs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function editState(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'state' => 'required'
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        $userInfo = User::find($user->id);
        $userInfo->interested_state = $request->state;
        $userInfo->save();

        return response()->json([
            'status' => 1,
            'message' => __("api.editstate_success")
        ]);

    }

    public function getIndustry(){
        $user = Auth::user();

        $industryExperience = IndustryExperience::where('user_id',$user->id)->get();
        
        return self::apiResponse(IndustryExperienceResource::collection($industryExperience), __("api.industry_experience_getdata"));
    }

    public function editIndustry(Request $request){
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'industryJourney' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        // delete past data :-
        $industryData = IndustryExperience::where('user_id',$user->id)->delete();

        // Industry Experience :-
        $industryJourney = $request->industryJourney;

        foreach ($industryJourney as $industryJourneyData) {

            $user->industry_experience()->create([
                'industry_name' => $industryJourneyData['industryName'],
                'experienced_year'  => $industryJourneyData['years'],
                'experienced_month' => $industryJourneyData['month'],
                'current_worked' => $industryJourneyData['isWorking'],
                'user_id' => $user->id
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => __("api.edit_industry_success")
        ]);
    }

    public function getCertificate(){
        $user = Auth::user();

        $certidicateDetails = CertificationDetails::where('user_id',$user->id)->get();

        return self::apiResponse(Certificates::collection($certidicateDetails), __("api.certificate_getdata"));


    }

    public function editCertificate(Request $request){
        
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'certificares' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        // dd($request->certificares);

        if($request->isPostman == 1){  // If 1 then check in postman else 0 means check APP

            // $cerificateData = CertificationDetails::where('user_id',$user->id)->get();

            // foreach ($cerificateData as $cert) {
            //     if ($cert->certification_doc && Storage::disk('public')->exists('Certificares/'.$cert->certification_doc)) {
            //         Storage::disk('public')->delete('Certificares/'.$cert->certification_doc);
            //     }
            //     $cert->delete();
            // }

            $certificares = json_decode($request->certificares, true);

            // 1. Get all existing certificate IDs for the user
            $existingCertificates = CertificationDetails::where('user_id', $user->id)->pluck('id')->toArray();

            // 2. Collect IDs sent in request (excluding new ones with itemId = 0)
            $submittedIds = collect($certificares)
                ->pluck('itemId')
                ->filter(fn($id) => $id >= 0)
                ->values()
                ->toArray();

            $idsToDelete = array_diff($existingCertificates, $submittedIds);

            if (!empty($idsToDelete)) {
                CertificationDetails::whereIn('id', $idsToDelete)->delete();
            }

            foreach ($certificares as $index => $certificaresData) {
                $itemId = $certificaresData['itemId'] ?? 0;

                if($certificaresData['otherCertificareName']){
    
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

                    if ($itemId == 0) {
                        // create new 
                        $user->certification_details()->create([
                            'user_id' => $user->id,
                            'certification_subname' => $certificaresData['otherCertificareName'],
                            // 'certification_doc'  => $imageName,
                            // 'expired_date' => $expireDate,
                        ]);
                    }else {
                        // Update existing
                        $existing = CertificationDetails::find($itemId);
                        if ($existing) {
                            $existing->update([
                                'certification_subname' => $certificaresData['otherCertificareName'],
                                // 'expired_date' => $expireDate,
                            ]);
                        }
                    }
    
    
                }else{
    
                    $expireDate = date('Y-m-d', strtotime($certificaresData['expireDate']));

                    //START: Image and doc store
                    $getImage = $request->certificateFile[$index];
                    $imageName = null;


                    if ($getImage instanceof \Illuminate\Http\UploadedFile) {
                        $directory = 'Certificares';
                        if (!Storage::disk('public')->exists($directory)) {
                            Storage::disk('public')->makeDirectory($directory);
                        }
                        $imageName = time() . '_' . uniqid() . '.' . $getImage->extension();
                        $getImage->storeAs($directory, $imageName, 'public');
                        // END: Image and doc store
                    }


                    if ($itemId == 0) {
                        // Create new
                        $user->certification_details()->create([
                            'user_id' => $user->id,
                            'certification_name' => $certificaresData['certificareType'],
                            'certification_doc' => $imageName,
                            'expired_date' => $expireDate,
                        ]);
                    } else {
                        // Update existing
                        $existing = CertificationDetails::find($itemId);
                        if ($existing) {
                            $existing->update([
                                'certification_name' =>$certificaresData['certificareType'],
                                'certification_doc' => $imageName ?? $existing->certification_doc,
                                'expired_date' => $expireDate,
                            ]);
                        }
                    }
    
                }
    
            }
            return response()->json([
                'status' => 1,
                'message' => __("api.edit_certificate_success")
            ]);
        }else{

            // $cerificateData = CertificationDetails::where('user_id',$user->id)->get();

            // foreach ($cerificateData as $cert) {
            //     if ($cert->certification_doc && Storage::disk('public')->exists('Certificares/'.$cert->certification_doc)) {
            //         Storage::disk('public')->delete('Certificares/'.$cert->certification_doc);
            //     }
            //     $cert->delete();
            // }

            $certificares = $request->certificares;
            // dd($certificares);


             // 1. Get all existing certificate IDs for the user
             $existingCertificates = CertificationDetails::where('user_id', $user->id)->pluck('id')->toArray();

             // 2. Collect IDs sent in request (excluding new ones with itemId = 0)
             $submittedIds = collect($certificares)
                 ->pluck('itemId')
                 ->filter(fn($id) => $id >= 0)
                 ->values()
                 ->toArray();
 
             $idsToDelete = array_diff($existingCertificates, $submittedIds);
 
             if (!empty($idsToDelete)) {
                 CertificationDetails::whereIn('id', $idsToDelete)->delete();
             }


            foreach ($certificares as $index => $certificaresData) {
                $itemId = $certificaresData['itemId'] ?? 0;
    

                if($certificaresData['otherCertificareName']){
    
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
    
                    if ($itemId == 0) {
                        // create new 
                        $user->certification_details()->create([
                            'user_id' => $user->id,
                            'certification_subname' => $certificaresData['otherCertificareName'],
                            // 'certification_doc'  => $imageName,
                            // 'expired_date' => $expireDate,
                        ]);
                    }else {
                        // Update existing
                        $existing = CertificationDetails::find($itemId);
                        if ($existing) {
                            $existing->update([
                                'certification_subname' => $certificaresData['otherCertificareName'],
                                // 'expired_date' => $expireDate,
                            ]);
                        }
                    }
    
    
                }else{
    
                    $expireDate = date('Y-m-d', strtotime($certificaresData['expireDate']));
    
                    //START: Image and doc store
                    // $getImage = $certificares->certificateFile;
                    // $getImage = $request->file("certificares.$index.certificateFile");
                    // $getImage = $request->certificateFile[$index];
                    // dd($getImage);
                    $getImage = $certificaresData['certificateFile'];
                    $imageName = null;


                    if ($getImage instanceof \Illuminate\Http\UploadedFile) {        
                        $directory = 'Certificares';
                        if (!Storage::disk('public')->exists($directory)) {
                            Storage::disk('public')->makeDirectory($directory);
                        }
                        $imageName = time() . '_' . uniqid() . '.' . $getImage->extension();
                        $getImage->storeAs($directory, $imageName, 'public');
                        // END: Image and doc store

                    }

                    // $user->certification_details()->create([
                    //     'user_id' => $user->id,
                    //     'certification_name' => $certificaresData['certificareType'],
                    //     'certification_doc'  => $imageName,
                    //     'expired_date' => $expireDate,
                    // ]);

                    if ($itemId == 0) {
                        // Create new
                        $user->certification_details()->create([
                            'user_id' => $user->id,
                            'certification_name' => $certificaresData['certificareType'],
                            'certification_doc' => $imageName,
                            'expired_date' => $expireDate,
                        ]);
                    } else {
                        // Update existing
                        $existing = CertificationDetails::find($itemId);
                        if ($existing) {
                            $existing->update([
                                'certification_name' =>$certificaresData['certificareType'],
                                'certification_doc' => $imageName ?? $existing->certification_doc,
                                'expired_date' => $expireDate,
                            ]);
                        }
                    }
    
                }
            }
    
            
            return response()->json([
                'status' => 1,
                'message' => __("api.edit_certificate_success")
            ]);
             
        }
    }

    public function getAvailabilityDates(){

        $user = Auth::user();
        $availabilityDate = AvailabilityDrivers::where('user_id', $user->id)
                            ->whereDate('available_date', '>=', Carbon::today())
                            ->orderby('available_date','ASC')
                            ->pluck('available_date') // Only get date column
                            ->map(function ($date) {
                                return Carbon::parse($date)->format('d-m-Y'); // Format to "DD-MM-YYYY"
                            })
                            ->values();

        return response()->json([
            'status' => 1,
            'message' => __("api.get_avaliable_success"),
            'data' => $availabilityDate
        ]);

    }

    public function editAvailabilityDates(Request $request){
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'availabilityDates' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }

        $availabilityDates = $request->availabilityDates;
       

        $newDates = collect($availabilityDates)
                    ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
                    ->filter(fn($date) => Carbon::parse($date)->greaterThanOrEqualTo(Carbon::today()))
                    ->unique();
        // dd($newDates);

        $currentDates = AvailabilityDrivers::where('user_id', Auth::id())
                    ->whereDate('available_date', '>', Carbon::today())
                    ->pluck('available_date')
                    ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));
        // dd($currentDates);

        $toInsert = $newDates->diff($currentDates);
        // dd($toInsert);
        foreach ($toInsert as $date) {
            AvailabilityDrivers::create([
                'user_id' => Auth::id(),
                'available_date' => $date,
            ]);
        }

        $toDelete = $currentDates->diff($newDates);
        // dd($toDelete);
        AvailabilityDrivers::where('user_id', Auth::id())
            ->whereIn('available_date', $toDelete)
            ->delete();

        
        return response()->json([
            'status' => 1,
            'message' => __("api.edit_availbile_date_success")
        ]);


    }

    public function getJob(){
        $jobs = Jobs::orderBy('id', 'desc')->get();
        return self::apiResponse(JobResource::collection($jobs), __("api.get_jobs"));
    }

    public function applyJob(Request $request){

        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'jobId' => 'required',
        ]);

        if ($validator->fails()) {
            return self::apiError($validator->errors()->first());
        }
        
        $jobDetail = AppliedJob::where(['user_id'=>$user->id,'job_id'=>$request->jobId])->first();
        $today = Carbon::today();
        // dd($jobDetail);
        if($jobDetail){
            return self::apiError(__('api.applied_job_already'));
 
        }else{
            $jobInfo = Jobs::where('id',$request->jobId)->first();
            if($jobInfo){

                $job =  new AppliedJob();
                $job->user_id = $user->id;
                $job->job_id = $request->jobId;
                $job->date = $today ;
                $job->save();
    
                return response()->json([
                    'status' => 1,
                    'message' => __("api.applied_jobs")
                ]);
            }else{
                 return self::apiError(__('api.job_issue'));

            }
        }

    }
}
