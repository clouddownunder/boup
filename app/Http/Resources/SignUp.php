<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Google\Service\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SignUp extends JsonResource
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
            'email' => valueOrEmptyString($this->email),
            'isProfileSetUp' => valueOrEmptyString($this->is_setup_profile),

            // 'profilePic' => $this->profile_pic ? url(Storage::url('profilepic/parent/' . $this->profile_pic)): '',
            // 'userType' => $this->user_type ?? 0,
            // 'stageVerify' => valueOrEmptyString($this->stage_verify),

            
            // 'profilePicture' => $this->profile_pic ? asset('consumer_profileimg/' . $this->profile_pic) : '',
            // 'dob' => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->format('d-m-Y') : '',
            // 'address' => valueOrEmptyString($this->address),
            // 'businessPicture' => $this->business_pic ? asset('business_profileimg/' . $this->business_pic) : '',
            // 'categoryName' => $this->Categories->category_name ?? '',


        ];
    }
}
