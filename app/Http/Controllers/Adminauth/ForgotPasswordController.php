<?php
// Added developer on 02-03-2017
// New ForgotPasswordController for 'Admin' section

namespace App\Http\Controllers\Adminauth;

use App\Http\Controllers\Controller;
use App\Mail\Adminforgotpassword;
use App\Models\Admin;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Auth;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
	protected $guard = 'admin';
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }
	
	public function showForgotPasswordForm() {
		if(Auth::guard('admin')->check()){
			return redirect('/admin');
		}
		return view('admin.auth.passwords.email');
	}
	
    /**
        * Send reset password link
    */
	public function sendResetLinkEmail(Request $request) {
		$this->validate($request,['email' => 'required|email']);


        $email = $request->email;
        
        $chk = Admin::where('email',$email)->first();
        
        if($chk == null){

            return redirect('/admin/password/reset')->with('error','Email is not registered yet.');
        }else{

            $admin_name = $chk->name;

            $val = DB::table('password_resets')->where('email',$email)->first();
            

                $token = Str::random(20);
                
                $store =  DB::table('password_resets')->updateOrInsert(
                    ['email' => $email],
                    ['token' => $token]
                );
                Mail::to($email)->send(new Adminforgotpassword($token,$admin_name));
                return redirect('/admin/password/reset')->with('success','Email has been sent to registered email.');

            }

    }
	
	public function broker() {
        return Password::broker('admins');
    }
	
	protected function sendResetLinkResponse($response) {
        return back()->with('status',trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request,$response){
		return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}