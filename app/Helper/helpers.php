<?php

use App\Models\ModifySession;
use App\Models\NotificationHistory;
use App\Models\PushNotification;
use App\Models\User;
use Intervention\Image\Facades\Image as Image;
use MonishKhatri\FCM\Service\FCMService;
use Illuminate\Support\Facades\Http;
use App\Models\NotificationSound;

function fetchDateFormate($date)
{
    return isset($date) ? date('d M, Y', strtotime($date)) : 'N/A';
}
function fetchDateTimeFormate($date)
{
    return date('d M Y g:i A', strtotime($date));
}
function wordWrapString($string, $length = 80)
{
    if (strlen($string) > $length) {
        $truncatedText = substr($string, 0, $length) . '...';
    } else {
        $truncatedText = $string;
    }

    return $truncatedText;
}
function valueOrEmptyString($value, $default = '')
{
    return $value ?? $default;
}

function ApiPaginationDefault()
{
    return 10;
}

function sendWebPushNotification($deviceTokens, $message)
{
    if (!empty($deviceTokens)) {
        // $pushNotification = new FCMService();
        // $pushNotification->setDeviceTokens($deviceTokens)
        //     ->setBody($message)
        //     ->setTitle(config('app.name'))
        //     ->setDataAsArray([
        //         "title" => config('app.name'),
        //         "body" => $message,
        //         "icon" => url(config('constant.LOGO_FAVICON')),
        //         'click_action' => 'OPEN_URL',
        //         'url' => config('app.url'),
        //     ])
        //     ->send();
        Http::acceptJson()
            ->withToken(config('push_notification.token'))
            ->post(
                'https://fcm.googleapis.com/fcm/send',
                [
                    'registration_ids' => $deviceTokens,
                    'notification' => [
                        'title' => config('app.name'),
                        'body' => strip_tags($message),
                        'sound' => 'default',
                        'largeIcon' => url(config('constant.LOGO_FAVICON')),
                        'image' => '',
                        'color' => '',
                        'vibrate' => 300,
                        'vibration' => false,
                        'notificationType' => "",
                        'badge' => ""
                    ],
                    'data' => [
                        'title' => config('app.name'),
                        'body' => $message,
                        'icon' => url(config('constant.LOGO_FAVICON')),
                        'notificationType' => "",
                        'url' => config('app.url'),
                        'badge' => 0
                    ],
                ]
            );
    }
}
function findStatus($status)
{
    if ($status == 'request') {
        $status = ModifySession::NOT_APPROVED;
    } else if ($status == 'approved') {
        $status = ModifySession::APPROVED;
    }
    if ($status == 'rejected') {
        $status = ModifySession::REJECTED;
    }
    return $status;
}
function numberFormat($value)
{
    return number_format($value, 2, '.', ',');
}
function sendPushNotification($notificationData, $userId)
{

    $user = User::find($userId);
    // dd($user->id);
    $sound_name = NotificationSound::where('user_id',$user->id)->first();
    if($sound_name == null){
        $sound = "bell_notification";
    }else{
        $sound = $sound_name->sound_name;
    }
    // dd($sound_name->sound_name);

    if (!empty($user->token)) {
        
        // $badgeCount = UserPushnotifications::where(['model_id' => $user->id, 'is_readed' => 0])->count();
        $client = new Google\Client();
        $client->setAuthConfig(storage_path('app/firebase_key.json'));
        $client->addScope(['https://www.googleapis.com/auth/firebase.messaging']);
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken()['access_token'];

        $url = 'https://fcm.googleapis.com/v1/projects/projectKeyName/messages:send';
        
    if($user->device_type == "1"){// iOS
        $fields = [
            "message"=> [
                "token"=>$user->token,
                "notification"=>[
                    "title"=>config('app.name'),
                    "body"=> strip_tags($notificationData['notification_text']),
                ],
                "data" => [
                    'title' => config('app.name'),
                    'body' => strip_tags($notificationData['notification_text']),
                    'icon' => url(config('constant.LOGO_FAVICON')),
                    'notificationType' => $notificationData['notification_type'],
                    'url' => config('app.url'),
                    // 'sound'=> $sound.".wav",
                    // 'badge' => $badgeCount
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => $sound.".wav",  // Add your custom sound here with .caf extension
                            "alert" => [
                                "title" => config('app.name'),
                                "body" => $notificationData['notification_text'],
                            ]
                        ]
                    ]
                ]
            
            ],
        ];
       
        \Log::info("iOS Push Test Debug: ".json_encode($fields));
        $headers = array(
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        \Log::info("iOS Push Test result: ".json_encode($result));      
        
        if ($result === FALSE)
        {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }
    if($user->device_type == "2"){ // Android
        // dd(config('app.name'));
        $fields = [
            "message"=> [
                "token"=>$user->token,
                "notification"=>[
                    "title"=>config('app.name'),
                    "body"=> strip_tags($notificationData['notification_text']),

                ],
                "data" => [
                    'title' => config('app.name'),
                    'body' => strip_tags($notificationData['notification_text']),
                    'icon' => url(config('constant.LOGO_FAVICON')),
                    'notificationType' => $notificationData['notification_type'],
                    'url' => config('app.url'),
                    "android_channel_id" => $sound,
                    "sound" => $sound,
                    // 'badge' => $badgeCount
                ],
                "android" => [
                    "notification" => [
                        "channel_id" => $sound,
                        "sound" => $sound, // Add your custom sound here (without file extension)
                    ]
                ]
            ],
        ];
       
        \Log::info("Android Push Test Debug: ".json_encode($fields));
        $headers = array(
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        \Log::info("Android Push Test result: ".json_encode($result));
        
        if ($result === FALSE)
        {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }
    
           
        // Http::acceptJson()
        //     ->withToken(config('push_notification.token'))
        //     ->post(
        //         'https://fcm.googleapis.com/fcm/send',
        //         [
        //             'registration_ids' => [$user->device_token],
        //             'notification' => [
        //                 'title' => config('app.name'),
        //                 'body' => strip_tags($notificationData['notification_text']),
        //                 'sound' => 'default',
        //                 'largeIcon' => url(config('constant.LOGO_FAVICON')),
        //                 'image' => '',
        //                 'color' => '',
        //                 'vibrate' => 300,
        //                 'vibration' => false,
        //                 'notificationType' => $notificationData['notification_type'],
        //                 'badge' => $badgeCount
        //             ],
        //             'data' => [
        //                 'title' => config('app.name'),
        //                 'body' => strip_tags($notificationData['notification_text']),
        //                 'icon' => url(config('constant.LOGO_FAVICON')),
        //                 'notificationType' => $notificationData['notification_type'],
        //                 'url' => config('app.url'),
        //                 'badge' => $badgeCount
        //             ],
        //         ]
        //     );
    }
}

function thumbnail($request, $name, $directory)
{
    $file = $request->file($name);
    $extension = $file->getClientOriginalName();
    $username = time() . '.' . $file->getClientOriginalExtension();
    $thumb = Image::make($file->getRealPath())->resize(100, 100, function ($constraint) {
        $constraint->aspectRatio(); //maintain image ratio
    });
    $destinationPath = storage_path('app/public/' . $directory);
    $file->move($destinationPath, $username);
    $thumb->save($destinationPath . '/thumb/' . $username);
    return $username;
}

function convertKeysToSnakeCase($array)
{
    $convertedArray = [];

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $convertedArray[Str::snake($key)] = convertKeysToSnakeCase($value);
        } else {
            $convertedArray[Str::snake($key)] = $value;
        }
    }

    return $convertedArray;
}
function sendMail($post = null, $templateName = null)
{

    if ($templateName) {
        $path = 'email/' . $templateName;
    } else {
        $path = 'email/defaultEmail';
    }
    try {
        \Mail::send($path, ['post' => $post], function ($message) use ($post) {
            $message->from("info@appgurus.com.au", "Boup");
            $message->to($post['email'])->subject($post['subject']);
        });
        return ['status' => 1, 'message' => "Email sent successfully."];
    } catch (Exception $e) {
        //dd($e->getMessage());
        return ['status' => 0, 'message' => $e->getMessage()];
    }
}
function get_address_by_latlng($lat, $lon)
{
    if ($lat == '' && $lon == '') {
        return 0;
    } else {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&key=" . env('GOOGLE_PLACES_API_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['results'][0]['formatted_address'];
        return $dist;
    }
}

function sendNotificationToDevice($deviceToken,$message,$deviceType,$notification_type = null,$notificationDatas = null){
    // dd($deviceToken,$notification_type,$message,$notificationDatas,$deviceType);
    $badgeCount = NotificationHistory::where(['user_id' => $notificationDatas['receiverId'], 'is_read' => 1])->count();

    $client = new Google\Client();
    $client->setAuthConfig(storage_path('app/firebase_key.json'));
    $client->addScope(['https://www.googleapis.com/auth/firebase.messaging']);
    $client->fetchAccessTokenWithAssertion();
    $accessToken = $client->getAccessToken()['access_token'];

    $url = 'https://fcm.googleapis.com/v1/projects/DiverHub-6465f/messages:send';
    // dd($url);
    if(!empty($deviceToken) && $deviceType=="1"){
        \Log::info("ios Push Test Start: ");
        $fields = [
            "message"=> [
                "token"=>$deviceToken,
                "notification"=>[
                    "title"=>config('app.name'),
                    "body"=> $notificationDatas['user_message'] ,
                ],
                "data" => [
                    'title' => config('app.name'),
                    'body' => $notificationDatas['user_message'] ,
                    'icon' => url(config('constant.LOGO_FAVICON')),
                    'notificationType' => (string)  $notification_type,
                    'url' => config('app.url'),
                    // 'badge' => $badgeCount

                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "Default.wav",  // Add your custom sound here with .caf extension
                            "alert" => [
                                "title" => config('app.name'),
                                "body" => $notificationDatas['user_message'],
                            ],
                            "badge" => $badgeCount
                        ]
                    ]
                ]

            ],
        ];
        \Log::info("ios Push Test Debug: ".json_encode($fields));

    } elseif(!empty($deviceToken) && $deviceType=="2") {
        \Log::info("Android Push Test Start: ");

        $fields = [
            "message"=> [
                "token"=>$deviceToken,
                "notification"=>[
                    "title"=>config('app.name'),
                    "body"=> $notificationDatas['user_message'],

                ],
                "data" => [
                    'title' => config('app.name'),
                    'body' => $notificationDatas['user_message'],
                    'icon' => url(config('constant.LOGO_FAVICON')),
                    'notificationType' => (string) $notification_type,
                    'url' => config('app.url'),
                    "android_channel_id" => "Default",
                    "sound" => "Default",
                    // 'badge' => $badgeCount
                ],
                "android" => [
                    "notification" => [
                        "channel_id" => "Default",
                        "sound" => "Default", // Add your custom sound here (without file extension)
                        "badge" => $badgeCount                        
                    ]
                ]
            ],
        ];
        \Log::info("Android Push Test Debug: ".json_encode($fields));

    }

    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization: Bearer '.$accessToken,
    );
    //print_r($fields);
    // \Log::info("Result: ".$accessToken );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    // \Log::info("Result: ".$result );
    
    // print_r($result);die;
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
}
