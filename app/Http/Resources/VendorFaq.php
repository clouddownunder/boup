<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorFaq extends JsonResource
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
            'faqId' => $this->id,
            'faqQue' => valueOrEmptyString($this->question),
            'faqAns' => valueOrEmptyString($this->answer),

        ];
    }
}
