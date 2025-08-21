<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class JobResource extends JsonResource
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
            'jobId' => valueOrEmptyString($this->id),
            'jobImage' => $this->user->business_logo ? url(Storage::url('business/logo/' . $this->user->business_logo)): asset('assets/images/businesslogo.png'),
            'jonName' => valueOrEmptyString($this->title),
            'companyName' => valueOrEmptyString($this->user->business_name),
            'companyAddress' => valueOrEmptyString($this->suburb),
            'companyEmail' => valueOrEmptyString($this->contact_email),
            'remainingDays' => valueOrEmptyString($this->duration),
            'jobPostedDate' => valueOrEmptyString(Carbon::parse($this->date)->format('d-m-Y')),
            'jobDescription' => valueOrEmptyString($this->description),

        ];

    }
}
