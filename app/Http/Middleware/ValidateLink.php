<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ValidateLink
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
        $data=DB::table('password_resets')->where('email',$request->email)->first();
        if(empty($data))
        {
            return redirect()->route('frontend.home')->withErrors(__('auth.link_expired'));
        }
        $tokens = DB::table('password_resets')->where('email',$request->email)->where('created_at','<',\Carbon\Carbon::now()->subMinute(20)->format('Y-m-d h:i:s'))->first();
        if(isset($tokens))
        {
            return redirect()->route('frontend.home')->withErrors(__('auth.link_expired'));
        }

        return $next($request);
    }
}
