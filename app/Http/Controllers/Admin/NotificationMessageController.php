<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationMessage;
use Yajra\Datatables\Datatables;
use Redirect;

class NotificationMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Message List";
        return view("admin.MessageNotification.index",compact('pageTitle'));
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

    public function getAllData(){
        if(isset($_REQUEST['order'])){
            $messageDataLIst = NotificationMessage::get();
        }
        else{
            $messageDataLIst = NotificationMessage::orderBy('is_display', 'DESC')->get(); 
        }
        
        return Datatables::of($messageDataLIst)
            ->addIndexColumn()
            ->setRowClass('viewInformation')
            ->setRowAttr([
                'data-id' => function($message) {
                    return $message->id;
                },
                'data-url' => function($message) {
                    return url("admin/notification-messages/".$message->id);
                },
            ])
            ->make(true);
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

    
    public function show($id)
    {
        // dd("hello");
        $messageDB = NotificationMessage::find($id);

        $page = "Message Details";
        if($messageDB){
            return view('admin.MessageNotification.view', compact('messageDB','page'));
        }
        else{
            return view('admin.layouts.includes.modalError');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        $messageDB = NotificationMessage::find($id);

        $page = "Message Details";
        if($messageDB){
            $messageDB->message = $request->message;
            $messageDB->save();

            return Redirect::to("admin/notification-messages")->with("success","Message has been updated successfully.");
        }
        else{
            return Redirect::to("admin/notification-messages")->with("error","Something went wrong. Please try again!!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
