<?php

namespace App\Http\Resources;

use App\Models\UserPushnotifications;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->fromUser;

        if ($this->from_model_type == UserPushnotifications::MODEL_TYPE_USER) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $profilePic = $user->profilePicture();
        } else {
            $firstName = $user->name;
            $lastName = $user->last_name;
            $profilePic = $user->profile_pic;
        }

        if (isset($this->is_count) && $this->is_count == 1) {
            return [
                'user_id' => valueOrEmptyString($user->id),
                'first_name' => valueOrEmptyString($firstName),
                'last_name' => valueOrEmptyString($lastName),
                'profile_pic_thumb' => valueOrEmptyString($profilePic),
                'notification_id' => valueOrEmptyString($this->id),
                // 'notification_message' => valueOrEmptyString($this->notification_text),
                'request_time' => valueOrEmptyString(Carbon::parse($this->created_at)->format('d/m/Y h:i')),
                // 'notification_type' => valueOrEmptyString($this->notification_type),
                // 'is_readed' => (int) valueOrEmptyString($this->is_readed),
                'is_spark' => (int) valueOrEmptyString($this->is_spark),
                'tell_me_why' => valueOrEmptyString($this->tell_me_why),
                // 'action_status' => valueOrEmptyString($this->action_status),
            ];
        }
        return [
            'user_id' => valueOrEmptyString($user->id),
            'first_name' => valueOrEmptyString($firstName),
            'last_name' => valueOrEmptyString($lastName),
            'profile_pic_thumb' => valueOrEmptyString($profilePic),
            'notification_id' => valueOrEmptyString($this->id),
            'notification_message' => valueOrEmptyString($this->notification_text),
            'notification_time' => valueOrEmptyString(Carbon::parse($this->created_at)->format('d/m/Y h:i')),
            'notification_type' => valueOrEmptyString($this->notification_type),
            'is_readed' => (int) valueOrEmptyString($this->is_readed),
            'is_spark' => (int) valueOrEmptyString($this->is_spark),
            'tell_me_why' => valueOrEmptyString($this->tell_me_why),
            'action_status' => valueOrEmptyString($this->action_status),
        ];
    }
}
