<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class bookinglist extends JsonResource
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
            'bookingId' => $this->id,
            'isBookingConfirmed' => valueOrEmptyString($this->is_booking_confirmed),
            'schoolName' => valueOrEmptyString($this->school_name),
            'address' => valueOrEmptyString($this->school_address),
            'bookingDate' => valueOrEmptyString(Carbon::parse($this->booking_date)->format('d M, Y')),
            'class' => valueOrEmptyString($this->class_name),
            'latitude'=> valueOrEmptyString($this->latitude),
            'longitude'=> valueOrEmptyString($this->longitude),

        ];
    }
}
