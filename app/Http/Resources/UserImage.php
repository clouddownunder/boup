<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImage extends JsonResource
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
            'profile_pic_id' => $this->id,
            'profile_pic' => valueOrEmptyString($this->image),
            'is_profile_pic' => valueOrEmptyString($this->is_profile_pic),
        ];
    }
}
