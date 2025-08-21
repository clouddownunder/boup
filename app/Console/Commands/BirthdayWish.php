<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserPushnotifications;
use MonishKhatri\FCM\Service\FCMService;
use Illuminate\Support\Facades\Http;
class BirthdayWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:birthdaywish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a birthday notification to the user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = now();
        $students = User::whereMonth('dob', $currentDate->format('m'))
            ->whereDay('dob', $currentDate->format('d'))
            ->get();

        // START:Push notification to students
        if ($students->isNotEmpty()) {
            $userPushNotification = [];
            // $pushNotification = new FCMService();

            foreach ($students as $user) {
                if (! empty($user->device_token)) {
                    $message = "Team Boup wishes you a Happy Birthday ". ucfirst($user->full_name).'!';

                    $userPushNotification[] = [
                        'user_id' => $user->id,
                        'notification_type' => '1',
                        'notification_text'=> $message,
                        'created_at' => $currentDate,
                        'updated_at' => $currentDate,
                    ];
                    UserPushnotifications::insert($userPushNotification);

                    $badgeCount = UserPushnotifications::where(['model_id' => $user->id, 'is_readed' => 0])->count();
                    Http::acceptJson()
                        ->withToken(config('push_notification.token'))
                        ->post(
                            'https://fcm.googleapis.com/fcm/send',
                            [
                                'registration_ids' => [$user->device_token],
                                'notification' => [
                                    'title' => config('app.name'),
                                    'body' => $message,
                                    'sound' => 'default',
                                    'largeIcon' => url(config('constant.LOGO_FAVICON')),
                                    'image' => '',
                                    'color' => '',
                                    'vibrate' => 300,
                                    'vibration' => false,
                                    'notificationType' => 1,
                                    'badge' => $badgeCount
                                ],
                                'data' => [
                                    'title' => config('app.name'),
                                    'body' => $message,
                                    'icon' => url(config('constant.LOGO_FAVICON')),
                                    'notificationType' => 1,
                                    'url' => config('app.url'),
                                    'badge' => $badgeCount
                                ],
                            ]
                        );
                    // $pushNotification->setDeviceTokens([$user->device_token])
                    //     ->setBody($message)
                    //     ->setNotificationType(1)
                    //     ->setDataAsArray(['notificationType' => 1])
                    //     ->send();
                }
            }
        }
        // END:Push notification to students
        $this->info('Birthwish processed Successfully!');
    }
}
