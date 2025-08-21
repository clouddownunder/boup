<?php
// Added developer on 02-03-2017
// New ResetPasswordController for 'Admin' section

namespace App\Http\Controllers\Adminauth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Buyers;
use App\Models\User;
use App\Models\Vendors;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class ResetPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
	protected $guard = 'admin';
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }
	
	public function showResetPasswordForm(Request $request, $token = null) {
        // dd($request->all());
        $val = DB::table('password_resets')->where('token',$token)->first();
        // dd($val);
        if($val){
            return view('admin.auth.passwords.reset')->with(
                ['token' => $token, 'email' => $val->email]
            );
        }else{
            return redirect('/admin/password/reset')->with('error','Invalid User.');

        }

	}

    public function userShowResetPasswordForm(Request $request, $token = null) {
        // dd($token);
        $val = DB::table('password_resets')->where('token',$token)->first();
        // dd($val);
        if($val){
            return view('admin.auth.passwords.userreset')->with(
                ['token' => $token, 'email' => $val->email]
            );
        }else{
            return redirect("/forgoterror");

        }

	}
	
	public function reset(Request $request) {
        // dd($request->all());
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $val = DB::table('password_resets')->where('token',$request->token)->first();

        if($val == null){
            return redirect("/admin/login")->withErrors(['msg'=> 'Invalid User.']);

        }else{
            // dd('updated');

            $pass= $request->password;
            $pass1= $request->password_confirmation;
            $email = $val->email;
            // dd($pass,$pass1);
            if($pass == $pass1){
                $passreal = hash::make($pass);
                // dd($passreal);
                $upd = Admin::where('email',$email)->update(['password'=> $passreal]);

                DB::table('password_resets')->where('email',$email)->delete();

                return redirect('/admin/login')->withSuccess('Password has been updated successfully.');

            }
        }
      
    }
    public function userReset(Request $request) {
        // dd($request->all());
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $val = DB::table('password_resets')->where('token',$request->token)->first();
        // dd($val);
        if($val == null){
            return redirect("/forgoterror");

        }else{
            // dd('updated');

            $pass= $request->password;
            $pass1= $request->password_confirmation;
            $email = $val->email;
            // dd($pass,$pass1);
            if($pass == $pass1){
                $passreal = hash::make($pass);
                // dd($passreal);
                $upd = Buyers::where('email',$email)->update(['password'=> $passreal]);

                DB::table('password_resets')->where('email',$email)->delete();

                return redirect("/thankyou");

            }
        }
      
    }


    public function vendorShowResetPasswordForm(Request $request, $token = null){
        // dd($token);
        $val = DB::table('password_resets')->where('token',$token)->first();
        // dd($val);
        if($val){
            return view('admin.auth.passwords.vendorreset')->with(
                ['token' => $token, 'email' => $val->email]
            );
        }else{
            return redirect("/forgoterror");

        }
    }

    public function vendorReset(Request $request) {
        // dd($request->all());
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $val = DB::table('password_resets')->where('token',$request->token)->first();
        // dd($val);
        if($val == null){
            return redirect("/forgoterror");

        }else{
            // dd('updated');

            $pass= $request->password;
            $pass1= $request->password_confirmation;
            $email = $val->email;
            // dd($pass,$pass1);
            if($pass == $pass1){
                $passreal = hash::make($pass);
                // dd($passreal);
                $upd = Vendors::where('email',$email)->update(['password'=> $passreal]);

                DB::table('password_resets')->where('email',$email)->delete();

                return redirect("/thankyou");

            }
        }
      
    }
	

}