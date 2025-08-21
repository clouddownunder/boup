<?php
// Added developer on 02-03-2017
// New LoginController for 'Admin' section

namespace App\Http\Controllers\Adminauth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {
    
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
	
    use AuthenticatesUsers;
	
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
	protected $redirectTo = '/admin/dashboard';
	protected $guard = 'admin';
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => ['logout','checkLogin']]);
    }
	
    /**
        * Show login form
    */
	public function showLoginForm(Request $request) {
		if(Auth::guard('admin')->check()){
			return redirect('/admin/dashboard');
		}
        $user_details = json_decode($request->cookie('user_details'),true);
        if (!empty($user_details)) {
            session()->flashInput($user_details);
        }
          return view('admin.auth.login');
	}
	
    /**
        * Processing to login admin
    */
	public function adminLogin(Request $request) {
		$this->validateLogin($request);
        $remember = (isset($request->remember)) ? true : false;
        if(isset($request['email']) && isset($request['password'])){
            $auth = auth()->guard('admin');
            $credentials = [
                'email' =>  $request['email'],
                'password' =>  $request['password'],
            ];
            if($auth->attempt($credentials)){
                if ($remember) {
                   return redirect()->action('App\Http\Controllers\Admin\DashboardController@index')->withCookie(cookie('user_details', json_encode(['email' => $request->email,'password' => $request->password,'remember' => true]), 60*30*24));;                     
                } else {
                    if (isset($request->email) && !empty($request->email)) {
                     $cookie = \Cookie::forget('user_details');
                        return redirect()->action('App\Http\Controllers\Admin\DashboardController@index')->withCookie($cookie);
                    } else {
                        return redirect()->action('App\Http\Controllers\Admin\DashboardController@index');
                    }
                }
            }else{
                return $this->sendFailedLoginResponse($request);
            }
        }else{
            return view('admin.auth.login');
        }
    }
	
	protected function validateLogin(Request $request) {
        $this->validate($request,[
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
    }
	
	public function loginUsername() {
        return property_exists($this,'username') ? $this->username : 'email';
    }
	
	protected function sendFailedLoginResponse(Request $request) {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
	
	protected function getFailedLoginMessage() {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }
	
	public function logout(Request $request) {
		Auth::guard('admin')->logout();
        $sessionId = $request->session()->getId();
        Session::getHandler()->destroy($sessionId); // Destroy the session for the specific guard
		return redirect('/admin/login');
	}
    public function checkLogin(){
        if (Auth::guard('admin')->check()) {
            echo 1;
        } else {
            echo 0;
        }
        die;
    }
}