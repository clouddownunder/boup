<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ShopInfo extends JsonResource
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
            'blurb' => valueOrEmptyString($this->id),
            'city' => valueOrEmptyString($this->suburb),
            'contactName' => valueOrEmptyString($this->contact_name),
            'email' => $this->email,
            'id' => $this->id,
            'isActive' => $this->status,

            'latitude' => valueOrEmptyString($this->latitude),
            'longitude' => valueOrEmptyString($this->longitude),

            'logo' => $this->logo ? url(Storage::url('business/logo/' . $this->logo)): '',
            'name' => valueOrEmptyString($this->name),

            'phoneNumber' => $this->phone_no,

            'postcode' => valueOrEmptyString($this->postcode),
            'publicCity' => valueOrEmptyString($this->suburb),
            'publicPostcode' => valueOrEmptyString($this->postcode),
            'publicState' => valueOrEmptyString($this->state),
            'publicStreetAddress1' => valueOrEmptyString($this->street_address1),
            'publicStreetAddress2' => valueOrEmptyString($this->street_address2),
            'region' => valueOrEmptyString($this->region),
            'shippingCost' => 0,
            'state' => valueOrEmptyString($this->state),
            'streetAddress1' => valueOrEmptyString($this->street_address1),
            'streetAddress2' => valueOrEmptyString($this->street_address2),
            'titleImage' => $this->title_image ? url(Storage::url('business/titleImage/' . $this->title_image)): '',
            'website' => valueOrEmptyString($this->website_url),




        ];
    }
}

