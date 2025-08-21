<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    protected $breadcrumb = "Terms and conditions";
    protected $pageTitle = "Terms and conditions";

    public function index(Request $request){
    	$breadcrumb = $this->breadcrumb;
        $pageTitle = $this->pageTitle;
        $agreement = PrivacyPolicy::first();

        return view("admin.privacypolicy",compact('agreement'));
    }

    public function saveContent(Request $request){
        $data =  PrivacyPolicy::find('1');
        $data->content = $request->agreement;
        $data->save();
        return redirect()->back();
    }
}
