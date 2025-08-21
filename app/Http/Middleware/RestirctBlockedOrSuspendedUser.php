<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use User;

class RestirctBlockedOrSuspendedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            $user = Auth::user();
            $status = $user->status;
            // dd($user);
            // $user->update(['last_active_time'=>date('Y-m-d H:i:s')]);
            if (in_array($status, [User::STATUS_SUSPENDED, User::STATUS_ADMIN_BLOCK] )) {
                $message = __('api.your_account_is_blocked');
                if ($status == User::STATUS_SUSPENDED) {

                    if ($user->suspend_end_date && Carbon::now()->gt(Carbon::parse($user->suspend_end_date))) {
                        // Auto-unblock
                        $user->status = 0;
                        $user->suspend_end_date = null;
                        $user->save();
                    } else {
                        // Still suspended
                        $message = __('api.your_account_is_suspended');
                        $suspended_lastdate = \Carbon\Carbon::parse($user->suspend_end_date)->format('d/m/Y');
    
                        $response = [
                            // 'status' => User::STATUS_BLOCK_SUSPENDED,
                            'status' => User::STATUS_BLOCK_SUSPENDED,
                            'message' => $message,
                            // 'suspended_last_date' => $suspended_lastdate,
                            // "server_date" => date('d/m/Y h:i')
                        ];
                        $user->token()->revoke();
                        return response()->json($response);
                    }
                }
                $response = [
                    // 'status' => User::STATUS_BLOCK_SUSPENDED,
                    'status' => User::STATUS_BLOCK_SUSPENDED,
                    'message' => $message,
                    // "server_date" => date('d/m/Y h:i')
                ];
                $user->token()->revoke();
                return response()->json($response);
            }
        }

        return $next($request);
    }
}
