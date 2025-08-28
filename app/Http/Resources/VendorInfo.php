<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorInfo extends JsonResource
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
            'userId' => $this->id,
            'name' => valueOrEmptyString($this->name),
            'email' => valueOrEmptyString($this->email),
            'dob' =>  $this->dob ? Carbon::parse($this->dob)->format('d, M Y') : '',
            'mailAddressStreet' => valueOrEmptyString($this->mailing_address),
            'mailAddressCity' => valueOrEmptyString($this->mailing_suburb),
            'mailAddressState' => valueOrEmptyString($this->mailing_state),
            'mailAddressPostcode' => valueOrEmptyString($this->mailing_postcode),
            'shippingAddressStreet' => valueOrEmptyString($this->map_address),
            'shippingAddressCity' => valueOrEmptyString($this->map_suburb),
            'shippingAddressState' => valueOrEmptyString($this->map_state),
            'shippingAddressPostcode' => valueOrEmptyString($this->map_postcode),
            'accessToken' => valueOrEmptyString($this->accessToken),
            'isProfileSetUp' => valueOrEmptyString($this->is_setup_profile),
            'deviceType' => valueOrEmptyString($this->device_type),

            'brewery' => false,
            'breweryId' => "",
            'isAdmin' => false,
            'isBrewery' => false,
            'location' => "",

        ];
    }
}
