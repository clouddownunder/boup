<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\ProfileMatchingController;
use App\Models\ReportUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use App\Models\BlockUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserProfile extends JsonResource
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
            // 'accessToken' => valueOrEmptyString($this->accessToken),
            'firstName' => valueOrEmptyString($this->first_name),
            'lastName' => valueOrEmptyString($this->last_name),
            'userType' => (int) $this->user_type ?? 0,
            'profilePic' => $this->profile_pic ? url(Storage::url('profileImg/' . $this->profile_pic)): '',
            'mobile' => valueOrEmptyString($this->mobile_no),
            'email' => valueOrEmptyString($this->email),
            'isProfileSetUp' => valueOrEmptyString($this->is_setup_profile),
            'suburb' => valueOrEmptyString($this->suburb),         
            'gender' => (int) $this->gender ?? 0,
            'state'=> $this->interested_state ?? ''

        ];
    }
}
