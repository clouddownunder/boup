<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndustryExperienceResource extends JsonResource
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
            'industryName' => valueOrEmptyString($this->industry_name),
            'years' => (int) $this->experienced_year ?? 0,
            'month' => (int) $this->experienced_month ?? 0,
            'isWorking' => valueOrEmptyString($this->current_worked),

        ];
    }
}
