<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class notificationlist extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'notificationId' => $this->id,
            'notificationTitle' => valueOrEmptyString($this->notification_title),
            'notificationMessage' => valueOrEmptyString($this->message),
            'notificationDate' => valueOrEmptyString(Carbon::parse($this->updated_at)->format('d M, Y h:i A')),
            'notificationType' => (int) $this->notification_type ?? 0,
        ];

    }
}
