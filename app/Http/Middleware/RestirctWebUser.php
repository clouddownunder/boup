<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestirctWebUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();

            if ($user->status == User::STATUS_SUSPENDED) {
                // Check if suspension has ended
                if ($user->suspend_end_date && Carbon::now()->gt(Carbon::parse($user->suspend_end_date))) {
                    // Auto-unblock
                    $user->status = 0;
                    $user->suspend_end_date = null;
                    $user->save();
                } else {
                    // Still suspended
                    $message = __('Your account is suspended until ') . Carbon::parse($user->suspend_end_date)->format('d M, Y');
                    Auth::guard('web')->logout();

                    return redirect()->route('portalLoginFrom')->with('error', $message);
                }
            }

            if ($user->status == User::STATUS_ADMIN_BLOCK) {
                $message = __('Your account is blocked by admin.');
                Auth::guard('web')->logout();

                return redirect()->route('portalLoginFrom')->with('error', $message);
            }
        }
        return $next($request);
    }
}
