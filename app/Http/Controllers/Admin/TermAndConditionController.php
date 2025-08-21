<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermAndCondition;
use Illuminate\Http\Request;

class TermAndConditionController extends Controller
{
    protected $breadcrumb = "Terms and conditions";
    protected $pageTitle = "Terms and conditions";

    public function index(Request $request){
    	$breadcrumb = $this->breadcrumb;
        $pageTitle = $this->pageTitle;
        $agreement = TermAndCondition::first();

        return view("admin.termsandcondition",compact('agreement'));
    }

    public function saveContent(Request $request){
        $data =  TermAndCondition::find('1');
        $data->content = $request->agreement;
        $data->save();
        return redirect()->back();
    }
}
