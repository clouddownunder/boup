<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationHistory;
use App\Models\PushNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    public function getalldata()
    {
        $notifications = PushNotification::orderBy('id', 'DESC')->get();
        return DataTables::of($notifications)
                ->addIndexColumn()
                ->editColumn('type', function($users){
                    $type = isset($users->type)?trim(ucfirst($users->type)):"ALL Users";
                    return $type;
                })
                // ->editColumn('description', function($users){
                //     $type = isset($users->type)?trim(ucfirst($users->type)):"ALL Users";
                //     return $type;
                // })
                ->editColumn('sent_on', function($users){
                    $sent_on = ! empty($users->created_at) ? fetchDateFormate($users->created_at) : 'N/A';
                    return $sent_on;
                })
                ->setRowAttr([
                    'data-id' => function($notifications) {
                        return $notifications->id;
                    },
                    'data-url' => function($notifications) {
                        return url("Notification/".$notifications->id);
                    },
                ])
                ->rawColumns(['name','status'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.NotificationManager.index')->with([
            'page' => "Push Notification Manager",
            'ajaxUrl' => route('Ajax.Notification'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'notificationTo' => 'required|max:150',
            'description' => 'required'
        ]); 

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $pushNotification=new PushNotification();
        $pushNotification->description=$request->description;
        $pushNotification->type=$request->notificationTo;
        $pushNotification->save();

        if($request->notificationTo == "Parents")
        {
            $data = User::where('user_type',1)->where('device_token',"!=",NULL)->get();
        }
        elseif($request->notificationTo == "Athletes")
        {
            $data = User::where('user_type',2)->where('device_token',"!=",NULL)->get();
        }
        else
        {
            $data = User::where('device_token',"!=",NULL)->get();    
        }
        // dd($data);
        foreach($data as $user)
        {
            if(!empty($user['device_token']))
            {
                $notifyMessage = $request->description;
                // insert notification in history
                $notify = new NotificationHistory();
                $notify->sender_type = 0;
                $notify->user_id = $user['id'];
                $notify->notification_type = '1';
                $notify->device_type = $user['device_type'];
                $notify->message = $notifyMessage;
                $notify->notification_title = "Admin Announcement";
                $notify->is_read = "1";
                $notify->save();

                // $notificationCount = NotificationHistory::where('receiver_id',$user['id'])->count();

                // send notification
                $notificationDatas['user_message'] = $notifyMessage;
                // $notificationDatas['notificationCount'] = $notificationCount;
                $notificationDatas['senderId'] = 0;
                $notificationDatas['receiverId'] = $user['id'];
                $notificationDatas['device_type'] = $user['device_type'];
                sendNotificationToDevice($user['device_token'],$notifyMessage,$user['device_type'],1,$notificationDatas);
            }
        }

        return Redirect::to("admin/notification")->with("success","Notificaton sent successfully.");
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
