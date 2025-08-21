<?php

use App\Http\Controllers\Api\BuyerController;
use App\Http\Controllers\Api\FeedbackController;


use App\Http\Controllers\Api\SettingController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/buyer/signUp', [BuyerController::class, 'signup']);
Route::post('/buyer/signIn', [BuyerController::class, 'signIn']);
Route::post('/buyer/forgotPassword', [BuyerController::class, 'forgetPassword']);

Route::post('/vendor/signUp', [VendorController::class, 'signup']);
Route::post('/vendor/signIn', [VendorController::class, 'signIn']);
Route::post('/vendor/forgotPassword', [VendorController::class, 'forgetPassword']);



// Route::post('/sendOTP', [UserController::class, 'sendOTP']);
// // Route::post('/verifyOTP', [UserController::class, 'verifyOTP']);


// Route::middleware(['auth:api', 'restrict_blocked_or_suspended_user'])->group(function () {
//     Route::middleware(['auth:api'])->group(function () {


//         // Profile Setup API
//         Route::post('/profileSetup', [UserController::class, 'profileSetup']);
//         Route::post('/editProfile', [UserController::class, 'editProfile']);

//         // Setting API : Edit details
//         Route::post('/editState', [SettingController::class, 'editState']);

//         Route::get('/getIndustry', [SettingController::class, 'getIndustry']);
//         Route::post('/editIndustry', [SettingController::class, 'editIndustry']);

//         Route::get('/getCertificate', [SettingController::class, 'getCertificate']);
//         Route::post('/editCertificate', [SettingController::class, 'editCertificate']);

//         Route::get('/getAvailabilityDates', [SettingController::class, 'getAvailabilityDates']);
//         Route::post('/editAvailabilityDates', [SettingController::class, 'editAvailabilityDates']);


//         Route::get('/getJob', [SettingController::class, 'getJob']);
//         Route::post('/applyJob',[SettingController::class, 'applyJob']);


//         // Setting API
//         Route::post('/logout', [UserController::class, 'logout']);
//         Route::post('/feedback', [FeedbackController::class, 'store']);
        
//         Route::post('/changePassword', [UserController::class, 'changePassword']);
//         Route::delete('/deleteAccount', [UserController::class, 'destroy']);



        
//     });
// });

Route::middleware(['auth:buyer'])->group(function () {
    Route::group(['prefix' => 'buyer'], function () {

        Route::post('/logout', [BuyerController::class, 'logout']);

        // Profile Setup
        Route::post('/setupProfile', [BuyerController::class, 'setupProfile']);
        Route::post('/editProfile', [BuyerController::class, 'editProfile']);
        Route::post('/editAddress', [BuyerController::class, 'editAddress']);

        Route::post('/changePassword', [BuyerController::class, 'changePassword']);
        Route::post('/deleteAccount', [BuyerController::class, 'destroy']);

        Route::get('/getFaq', [BuyerController::class, 'getfaq']);
        Route::get('/about', [BuyerController::class, 'about']);




    });


});

Route::middleware(['auth:vendor'])->group(function () {
    Route::group(['prefix' => 'vendor'], function () {
        Route::post('/logout', [VendorController::class, 'logout']);

        Route::post('/changePassword', [VendorController::class, 'changePassword']);
        Route::post('/deleteAccount', [VendorController::class, 'destroy']);

        Route::post('/editProfile', [VendorController::class, 'editProfile']);
        
        Route::post('/businessProfile', [VendorController::class, 'businessProfile']);
        Route::post('/businessBranding', [VendorController::class, 'businessBranding']);
        Route::post('/editAddress', [VendorController::class, 'editAddress']);

        Route::get('/getFaq', [VendorController::class, 'getfaq']);



    });


});