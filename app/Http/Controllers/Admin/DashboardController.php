<?php

/**
 * Author Name: LS
 * Datetime: 2021-08-16
 * Dashboard Controller class for dashboard 'Admin' section
 **/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyers;
// use App\Models\UserMatch;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\PaymentHistory;
use App\Models\programBooking;
use App\Models\ProgramDetails;
use App\Models\User;
use App\Models\User_booking;
use App\Models\UserSubscription;
use App\Models\Vendors;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $breadcrumb = "Dashboard";
    protected $pageTitle = "Dashboard";

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $breadcrumb = $this->breadcrumb;
        $pageTitle = $this->pageTitle;

        $commercial = Buyers::count();
        $diverSup = Vendors::count();
        // $companies = User::where('user_type',3)->count();

        $trial_user = 0;
        $totalRevenue = 0;
        $Unsubscribed = 0;

        $userRange  = $userstartDate = $userendDate = $userToDate  = "";
        $subscriptionRange = $subscriptionstartDate = $subscriptionendDate = $subscriptionToDate = $subscriptionType  = "";

        $boxes = [
            'users' => [
                ['text' => 'Total Buyer', 'value' => $commercial],
                ['text' => 'Total Vendor', 'value' => $diverSup],
                // ['text' => 'Total Diving Companies', 'value' => $companies],

                // ['text' => 'Total Offered Programs', 'value' => $totalProgram],
                // ['text' => 'Total booked Programs', 'value' => $totalBookings],

            ],

        ];

        return view(
            "admin.dashboard",
            compact(
                'boxes',

                'pageTitle',
                'userRange',
                'userstartDate',
                'userendDate',
                'userToDate',

                'subscriptionRange',
                'subscriptionstartDate',
                'subscriptionendDate',
                'subscriptionToDate',
                'subscriptionType',

            )
        );
    }

    public function filter(Request $request)
    {
        $commercialusers = Buyers::query();
        $diverSupusers = Vendors::query();
        // $companiesusers = User::query();

        // User Filter
        if ($request->userRange == "daily") {
            $commercialusers->whereDate('created_at', Carbon::now()->toDateString());
            $diverSupusers->whereDate('created_at', Carbon::now()->toDateString());
            // $companiesusers->whereDay('created_at', '=', Carbon::now()->toDateString());
    
        } elseif ($request->userRange == "weekly") {
            $commercialusers->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $diverSupusers->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            // $companiesusers->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        } elseif ($request->userRange == "monthly") {
            $commercialusers->whereMonth('created_at', '=', date('m'));
            $diverSupusers->whereMonth('created_at', '=', date('m'));
            // $companiesusers->whereMonth('created_at', '=', date('m'));



        } elseif ($request->userRange == "quarterly") {
            $date = new \Carbon\Carbon('-3 months');
            $commercialusers->whereBetween('created_at', [$date->startOfQuarter(), now()]);
            $diverSupusers->whereBetween('created_at', [$date->startOfQuarter(), now()]);
            // $companiesusers->whereBetween('created_at', [$date->startOfQuarter(), now()]);

        } elseif ($request->userRange == "yearly") {
            $commercialusers->whereYear('created_at', '=', date('Y'));
            $diverSupusers->whereYear('created_at', '=', date('Y'));
            // $companiesusers->whereYear('created_at', '=', date('Y'));


        } elseif ($request->userRange == "custom") {
            $commercialusers->whereBetween('created_at', [$request->userstartDate, $request->userendDate]);
            $diverSupusers->whereBetween('created_at', [$request->userstartDate, $request->userendDate]);
            // $companiesusers->whereBetween('created_at', [$request->userstartDate, $request->userendDate]);


        } elseif ($request->userRange == "todate" && $request->userTodate != "") {
            $commercialusers->where('created_at', '<=', $request->userTodate);
            $diverSupusers->where('created_at', '<=', $request->userTodate);
            // $companiesusers->where('created_at', '<=', $request->userTodate);

        }

        // Subscription Filter :-
        // dd(Carbon::now()->toDateString());
        $commercial = $commercialusers->count();
        $diverSup = $diverSupusers->count();
        // $companies = $companiesusers->where('user_type',3)->count();


        $boxes = [
            'users' => [
                ['text' => 'Total Buyer', 'value' => $commercial],
                ['text' => 'Total Vendor', 'value' => $diverSup],
                // ['text' => 'Total Diving Companies', 'value' => $companies],

            ],


        ];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'boxes' => $boxes
            ]);
        }

        
    }
}
