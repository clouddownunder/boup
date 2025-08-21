<?php

use App\Http\Controllers\Admin\AffiliationManagementController;
use App\Http\Controllers\Admin\ApiMessagesController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ModifyController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SessionBookingController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Portal\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();



Route::get('/', function () {
    return redirect()->route('adminLoginFrom');
})->name('frontend.home');
// Route::get('portal/terms-and-conditions', function () {
//     return view('tc');
// })->name('t&c');
// Route::get('portal/privacy-and-policy', function () {
//     return view('pp');
// })->name('p&p');

Route::get('/thankyou', function () {
    return view('forgotpasswordsuccess');
});
Route::get('/forgoterror', function () { 
    return view('forgotpassworderror');
});
// Route::get('/payment-success', function () {
//     return view('paymentsuccess');
// });
// Route::get('/payment-cancelled', function () {
//     return view('paymenterror');
// });


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // Authentication Routes..
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    // Registration Routes... 
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
 
    // Admin Urls
    Route::get('admin/login', 'Adminauth\LoginController@showLoginForm')->name('adminLoginFrom');
    Route::post('admin/login', 'Adminauth\LoginController@adminLogin')->name('adminlogin');
    Route::post('admin/logout', 'Adminauth\LoginController@logout')->name('adminlogout');
    Route::get('/admin/password/reset', 'Adminauth\ForgotPasswordController@showForgotPasswordForm')->name('forgotpasswordform');
    Route::post('/admin/password/email', 'Adminauth\ForgotPasswordController@sendResetLinkEmail')->name('adminforgotpassword');
    Route::get('/admin/password/reset/{token}', 'Adminauth\ResetPasswordController@showResetPasswordForm')->name('showResetPasswordForm');
    Route::post('/admin/password/reset', 'Adminauth\ResetPasswordController@reset')->name('adminResetPassword');

    Route::get('/password/reset/{token}', 'Adminauth\ResetPasswordController@userShowResetPasswordForm')->name('userShowResetPasswordForm');
    Route::post('/password/reset', 'Adminauth\ResetPasswordController@userReset')->name('userResetPassword');

    Route::get('/vendor/password/reset/{token}', 'Adminauth\ResetPasswordController@vendorShowResetPasswordForm')->name('vendorShowResetPasswordForm');
    Route::post('/vendor/password/reset', 'Adminauth\ResetPasswordController@vendorReset')->name('vendorResetPassword');




});

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth:admin']], function () {
    /*DASHBOARD CONTROLLER*/
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::post('dashboard', 'DashboardController@filter')->name('filter');
    Route::resource('user-profile', 'ProfileController');
    Route::post('/changePassword/{id}', 'ProfileController@changePassword')->name('changePassword');



    /*REGISTERED USER CONTROLLER*/
    Route::get('users/export/{id}', 'UsersController@export');
    Route::resource('users', 'UsersController')->only(['index', 'destroy']);
    Route::get('/users/{id}/{type}', [UsersController::class, 'show'])->name('admin.users.show');


    Route::get('user-feedbacks/getalldata', 'FeedbackController@getalldata');
    Route::resource('user-feedbacks', 'FeedbackController');
    Route::resource('feedback', 'FeedbackController');



    Route::get('api-messages', [ApiMessagesController::class, 'index'])->name('ApiMessages.index');
    Route::get('api-messages/{key}', [ApiMessagesController::class, 'show'])->name('ApiMessages.show');
    Route::put('api-messages/{key}', [ApiMessagesController::class, 'update'])->name('ApiMessages.update');

    Route::get('Affiliate', 'AffiliationManagementController@index')->name('Affiliate.index');
    Route::post('Affiliate/New', 'AffiliationManagementController@store')->name('createAffiliate');
    Route::delete('Affiliate/{affiliate}/delete', 'AffiliationManagementController@destroy')->name('deleteAffiliate');
    Route::post('Affiliate/{affiliate}/update', 'AffiliationManagementController@update')->name('updateAffiliate');
    Route::get('Affiliate/{affiliate}', 'AffiliationManagementController@show')->name('showAffiliate');
    Route::post('post-reorder', 'AffiliationManagementController@reorder')->name('reorder');
    Route::resource('faq-management', 'FaqController');
    Route::post('faq/sortable', 'FaqController@sortable');

    Route::get('terms-of-use', 'TermAndConditionController@index')->name('admin.termAndCondition');
    Route::post('terms-of-use', 'TermAndConditionController@saveContent')->name('admin.saveContent');

    Route::get('privacy-policy', 'PrivacyPolicyController@index')->name('admin.privacyPolicy');
    Route::post('privacy-policy', 'PrivacyPolicyController@saveContent')->name('admin.ppsaveContent');


    Route::post('users/storeAction', [UsersController::class, 'storeAction']);
    Route::resource('notification', 'NotificationController');
    Route::resource('jobs', 'JobController');




    
});

Route::group(['prefix' => 'admin-api'], function () {
   
    Route::get('users/getAllData', [UsersController::class, 'getalldata']);

    Route::get('feedback-list/getAllData', [FeedbackController::class, 'getalldata']);

    Route::post('faq/sortable', [FaqController::class, 'sortable']);
    Route::get('faq-management/getAllFaq', [FaqController::class, 'getAllFaq']);
    Route::get('api-message-list/getAllData', [ApiMessagesController::class, 'getalldata']);
    Route::get('Affiliate/getAllData', [AffiliationManagementController::class, 'getalldata']);

    Route::get('notification/getAllData', [NotificationController::class,'getalldata'])->name('Ajax.Notification');
    Route::get('jobs/getAllData', [JobController::class,'getalldata']);


});

