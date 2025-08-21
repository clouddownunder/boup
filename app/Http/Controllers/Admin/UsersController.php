<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserPushnotifications;
use App\Models\callSummery;
use App\Models\BlockUser;
use App\Models\Feedback;
use App\Models\UserMatch;
use App\Models\UserImage;
use App\Models\User_booking;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendActionMail;
use App\Models\AvailabilityDrivers;
use App\Models\Buyers;
use App\Models\CertificationDetails;
use App\Models\ChildrenInfo;
use App\Models\IndustryExperience;
use App\Models\PaymentHistory;
use App\Models\ReportUser;
use App\Models\Settings;
use App\Models\Vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    public function getalldata(Request $request)
    {
        // dd($request->type);
        if($request->type == 1){
            $users = Buyers::orderBy('id', 'DESC')->get();
        }else{
            $users = Vendors::orderBy('id', 'DESC')->get();
        }

        return Datatables::of($users)
            ->addIndexColumn()
            ->editColumn('userType', function ($users) { //1 = Parent , 2 = Athletes
                if($users->user_type == 1){
                    $userType = "Buyer";
                    return $userType;
                }elseif($users->user_type == 2){
                    $userType = "Vendor";
                    return $userType;
                }else{
                    $userType = "N/A";
                    return $userType;
                }
            })
            ->editColumn('email', function ($users) {
                $email = isset($users->email) ? trim($users->email) : "N/A";
                return $email;
            })
            ->editColumn('mobilenumber', function ($users) {
                $mobile = isset($users->mobile_no) ? trim($users->mobile_no) : "N/A";
                return "+61 ".$mobile;
            })
            
            ->addColumn('photo', function ($users) {
                if($users->profile_pic){
                    $logo = valueOrEmptyString(asset('storage/profileImg/' . $users->profile_pic), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '" style="width: 40px; height: 40px;"></a>';    
                    return  $profile;
                }else{
                    $logo = valueOrEmptyString(asset('images/default_image.png'), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '"></a>';    
                    return  $profile;
                }
            })

            ->addColumn('logo', function ($users) {
                if($users->business_logo){
                    $logo = valueOrEmptyString(asset('storage/business/logo/' . $users->business_logo), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '" style="width: 40px; height: 40px;"></a>';    
                    return  $profile;
                }else{
                    $logo = valueOrEmptyString(asset('assets/images/businesslogo.png'), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '"></a>';    
                    return  $profile;
                }
            })
            ->editColumn('name', function ($users) {
                $name = isset($users->business_name) ? trim($users->business_name) : "N/A";
                return $name;
            })
            ->editColumn('firstName', function ($users) {
                $firstName = isset($users->first_name) ? trim($users->first_name) : "N/A";
                return $firstName;
            })
            ->editColumn('lastName', function ($users) {
                $lastName = isset($users->last_name) ? trim($users->last_name) : "N/A";
                return $lastName;
            })   
            ->editColumn('profileLink', function ($users) {
                $profileLink = isset($users->business_profile_link) ? trim($users->business_profile_link) : "N/A";
                return $profileLink;
            })            
            ->setRowClass('viewInformation')
            ->setRowAttr([
                'data-id' => function ($user) {
                    return $user->id;
                },
                'data-url' => function ($user) use ($request) {
                    return url("/admin/users/" . $user->id ."/".$request->type);
                },
            ])
            ->rawColumns(['userType','photo','email','mobilenumber','firstName','lastName','profileLink','logo','name'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id','DESC')->get();
        return view('admin.Users.index',['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$type)
    {
        if($type == 1){
            $user = Buyers::where('id', $id)->first();
        }else{
            $user = Vendors::where('id', $id)->first();
        }

        $setting = Settings::where('setting_key','show_device_info')->first();
        $show_device_info = $setting->setting_value;

        if ($user) {
            return view('admin.Users.view', compact('user', 'type','show_device_info'));
        } else {
            return view('admin.layouts.includes.modalError');
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
        try {       
            $user =  User::find($id);
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User has been deleted successfully.');

        } catch (Exeception $e) {
            return response()
                ->json(['success' => false]);
        }
    }
    



    public function export()
    {
        $users = User::with('ChildrenInfo')->get();
        return Excel::download(new UsersExport($users), 'Users_' . date('d-m-Y') . '.csv');
    }

    public function storeAction(Request $request){
        // dd($request->all());
        $action = $request->input('action'); // 'suspend' or 'block'
        $reason = $request->input('reason');
        $userId = $request->input('user_id');
        // dd($reason);
    
        // Perform different logic
        if ($action == 'suspend') {
            $now = Carbon::now();
            $futureDate = $now->copy()->addDays(30);
            // dd($now,$futureDate);

            $user = User::find($userId);
            $user->suspend_end_date = $futureDate;
            $user->status = 2;
            $user->reason = $reason;
            $user->save();


        } elseif ($action == 'block') {
            // block logic
            $user = User::find($userId);
            $user->status = 1;
            $user->reason = $reason;
            $user->save();
        }
        elseif ($action == 'unblock') {
            // unblock logic
            $user = User::find($userId);
            $user->status = 0;
            $user->reason = $reason;
            $user->save();
        }
        elseif ($action == 'unsuspend') {
            // unsuspend logic
            $user = User::find($userId);
            $user->status = 0;
            $user->reason = $reason;
            $user->save();
            $action = "Revoke";
        }
        elseif ($action == 'approve') {
            // unsuspend logic
            $user = User::find($userId);
            $user->medical_clearance = 0;
            $user->save();
        }
    
        // return response()->json(['message' => ucfirst($action) . ' user successful!']);
        return response()->json([
            'message' => ucfirst($action) . ' user successful!',
            'redirect_url' => route('users.index') // or any other route
        ]);
    }
}
