<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Jobs;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;


class JobController extends Controller
{
    public function getalldata(Request $request)
    {
        $jobs = Jobs::orderBy('id', 'DESC')->get();

        return Datatables::of($jobs)
            ->addIndexColumn()
            ->editColumn('comapanyName', function ($jobs) {
                $companyName = isset($jobs->user->business_name) ? trim($jobs->user->business_name) : "N/A";
                return $companyName;
            })
            ->addColumn('logo', function ($jobs) {
                if($jobs->user->business_logo){
                    $logo = valueOrEmptyString(asset('storage/business/logo/' . $jobs->user->business_logo), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '" style="width: 40px; height: 40px;"></a>';    
                    return  $profile;
                }else{
                    $logo = valueOrEmptyString(asset('assets/images/businesslogo.png'), "N/A");
                    $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $logo. '"></a>';    
                    return  $profile;
                }
            })
            ->editColumn('email', function ($jobs) {
                $email = isset($jobs->contact_email) ? trim($jobs->contact_email) : "N/A";
                return $email;
            })
            ->editColumn('jobtitle', function ($jobs) {
                $jobtitle = isset($jobs->title) ? trim($jobs->title) : "N/A";
                return $jobtitle;
            })
            ->editColumn('duration', function ($jobs) {
                $duration = isset($jobs->duration) ? trim($jobs->duration) : "N/A";
                return $duration;
            })
       
            ->setRowClass('viewInformation')
            ->setRowAttr([
                'data-id' => function ($jobs) {
                    return $jobs->id;
                },
                'data-url' => function ($jobs) {
                    return url("/admin/jobs/" . $jobs->id);
                },
            ])
            ->rawColumns(['comapanyName','logo','email','jobtitle','duration'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job = Jobs::orderBy('id','DESC')->get();
        return view('admin.Jobs.index',['job'=>$job]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = "Jobs";
        $jobs = Jobs::where('id', $id)->first();

        if ($jobs) {
            return view('admin.Jobs.view', compact('jobs', 'page'));
        } else {
            return view('admin.layouts.includes.modalError');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
    



    public function export()
    {

    }

}
