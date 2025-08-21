<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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

            'expiryDate' => valueOrEmptyString(Carbon::parse($this->end_date)->format('d/m/Y H:i')),
            'serverDate' => valueOrEmptyString(now()->format('d/m/Y H:i')),
        ];
    }
}
