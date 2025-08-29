<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MapShopInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fullAddress = implode(', ', array_filter([
            valueOrEmptyString($this->street_address1),
            valueOrEmptyString($this->street_address2),
            valueOrEmptyString($this->suburb),
            trim(valueOrEmptyString($this->state) .' '.valueOrEmptyString($this->postcode)),

        ]));
        return [

            'shopId' => $this->id,
            'shopName' => valueOrEmptyString($this->business_name),
            'address' =>  $fullAddress,
            'latitude' => valueOrEmptyString($this->latitude),
            'longitude' => valueOrEmptyString($this->longitude),
            'shopImage' => $this->logo ? url(Storage::url('business/logo/' . $this->logo)): '',
            'category' => ''

        ];
    }
}
