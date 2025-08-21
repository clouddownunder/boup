<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SignIn extends JsonResource
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
            'accessToken' => valueOrEmptyString($this->accessToken),
            'firstName' => valueOrEmptyString($this->first_name),
            'lastName' => valueOrEmptyString($this->last_name),
            'userType' => $this->user_type ?? 0,
            'profilePic' => $this->profile_pic ? url(Storage::url('profileImg/' . $this->profile_pic)): '',
            'mobile' => valueOrEmptyString($this->mobile_no),
            'email' => valueOrEmptyString($this->email),
            'isProfileSetUp' => valueOrEmptyString($this->is_setup_profile),
            'suburb' => valueOrEmptyString($this->suburb),
            'gender' =>  $this->gender ?? 0,
            'state'=> $this->interested_state ?? ''

        ];
    }
}
