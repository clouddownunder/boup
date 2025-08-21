<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Profile";
        $user = Auth::guard('admin')->user();
        return view("admin.userProfile", compact('user','pageTitle'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all(),$id);
        $user = Admin::find($id);
        $this->validate($request, [
            'name' => 'required',
        ],
        [
            'name.required'    => 'Name is required field.',
        ]);

        $this->validate($request, [
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if(!empty($request->user_profile_pic))
        {
         if($request->user_profile_pic){
            $imageMainPath = '/admin_bkp/profile_pics/';

            if (!is_dir(public_path($imageMainPath))) {
                mkdir(public_path($imageMainPath), 777, true);
            }


            $profileImage = "admin-profile-".time().".png";
            $path = public_path($imageMainPath.$profileImage);

            $image = $request->user_profile_pic;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            \File::put($path, base64_decode($image));

            $user->profile_pics = $profileImage;

             } else{
                return Redirect::back()->with("danger","Please select jpg, png, gif only");
            }

        }

        $user->name = $request->name;
        $user->save();
        return redirect()->back()->with("success","Profile updated successfully.");
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

    /**
        * Change account password
    */
    public function changePassword(Request $request, $id){
        // dd($request->all(),$id);
        $user = Admin::find($id);

        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ],
        [
            'current_password.required'    => 'The current password field is required.',
            'new_password.min'    => 'The password must be at least 8 characters.',
        ]);

        if (!(Hash::check($request->get('current_password'), $user->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Current Password doesn't match.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Current Password and New Password should not be same.");
        }


        $user->password = bcrypt($request->get('new_password'));
        $user->save();

    return redirect()->back()->with("success","Password has been changed successfully.");
    }
}
