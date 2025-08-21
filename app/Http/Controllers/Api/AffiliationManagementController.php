<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AffiliationManagementResource;
use App\Models\AffiliationManagement;
use Illuminate\Http\Request;

class AffiliationManagementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAffliations()
    {
        
        // $affiliationData = AffiliationManagement::all();
        

        // return self::apiResponse( AffiliationManagementResource::collection($affiliationData), __("api.affiliation_success"));
    }
}
