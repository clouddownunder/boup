<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FeedbackController extends Controller
{
    public function getalldata()
    {
        $feedback = Feedback::orderBy('id', 'DESC')->get();
        // $feedback = Feedback::orderBy('id', 'DESC')->get()->unique('user_id')->values();
        return Datatables::of($feedback)           
                ->addIndexColumn()
                ->editColumn('userType', function ($feedback) { 
                    if($feedback->user->user_type === 1){
                        $userType = "Commercial Diver";
                        return $userType;
                    }elseif($feedback->user->user_type === 2){
                        $userType = "Diver Supervisor";
                        return $userType;
                    }elseif($feedback->user->user_type === 3){
                        $userType = "Diving Companies";
                        return $userType;
                    }else{
                        $userType = "N/A";
                        return $userType;
                    }   
                })
                ->editColumn('fullname', function ($feedback) {
                    $firstname = valueOrEmptyString(ucfirst($feedback->user->first_name), "N/A");
                    $lastname = valueOrEmptyString(ucfirst($feedback->user->last_name), "N/A");
                    // $firstname = $feedback->user->first_name;
                    return $firstname .' '. $lastname;
                })
                // ->editColumn('lastname', function ($feedback) {
                //     $lastname = valueOrEmptyString(ucfirst($feedback->user->last_name), "N/A");
                //     return $lastname;
                // })
                ->editColumn('experience', function ($feedback) {
                    $experience = substr_replace($feedback->experience, "...", 50);  
                    return $experience;
                })
                ->editColumn('suggestion', function ($feedback) {
                    $suggestion = substr_replace($feedback->suggestion, "...", 50);
                    return $suggestion;
                })
                ->editColumn('submitted_on', function ($feedback) {
                    $submitted_on = ! empty($feedback->feedback_date) ? fetchDateFormate($feedback->feedback_date) : 'N/A';
                    return $submitted_on;
                })
                ->setRowClass('viewInformation')
                ->setRowAttr([
                    'data-id' => function ($feedback) {
                        return $feedback->id;
                    },
                    'data-url' => function ($feedback) {
                        return url("/admin/feedback/".$feedback->id);
                    },
                ])
                ->rawColumns(['name','status'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Feedback List";
        $users = Feedback::orderBy('id', 'DESC')->get();
        return view('admin.Feedback.index',compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $page = "Feedback Details";
        $feedback = Feedback::where('id',$id)->first();

        // $feedbacks = Feedback::where('user_id',$feedback->user_id)->orderBy('id', 'DESC')->get();
        if($feedback){
            return view('admin.Feedback.view', compact('feedback','page'));
        }
        else{
            return view('admin.layouts.includes.modalError');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
