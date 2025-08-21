<?php

namespace App\Exceptions;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if ($request->expectsJson()) {
    //         $res = [
    //             'success' => 3,
    //             'message' => "Invalid tokan.",
    //         ];
    //         if(!empty($errorMsg)){
    //             $res['data'] = $errorMsg;
    //         }
    //         return response()->json($res, 401);
    //     }
    // }

    public function render($request, Throwable $e)
    {
        if($request->is('api/*'))
        {
            // dd($request,$e);
            if ($e instanceof AuthenticationException) {
                $response = [
                    'status' => User::STATUS_TOKEN_EXPIRED,
                    'message' => "Invalid Access Token.",
                    "server_date" => date('d/m/Y h:i')
                ];
                if(!empty($errorMsg)){
                    $response['data'] = $errorMsg;
                }
                return response()->json($response);
            }
            // Catch second logout hitting web.home
            if ($e instanceof RouteNotFoundException && str_contains($e->getMessage(), 'web.home')) {
                $response = [
                    'status' => User::STATUS_TOKEN_EXPIRED,
                    'message' => "Invalid Access Token.",
                    "server_date" => date('d/m/Y h:i')
                ];
                return response()->json($response, 401);
            }
        }
        if($request->is('admin/*'))
        {
            if ($e instanceof AuthenticationException) {
                return redirect()->route('adminlogin');
            }
        }
        return parent::render($request, $e);
    }
}
