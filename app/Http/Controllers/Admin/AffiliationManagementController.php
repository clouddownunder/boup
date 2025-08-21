<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\AffiliationManagement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AffiliationManagementController extends Controller
{
    public function getalldata()
    {
        if (isset($_REQUEST['order'])) {
            $affiliate = AffiliationManagement::get();
            // $affiliate = AffiliationManagement::orderBy('update_reorder', 'ASC')->get();
        } else {
            $affiliate = AffiliationManagement::orderBy('update_reorder', 'ASC')->get();
        }

        return Datatables::of($affiliate)
            ->addIndexColumn()
            ->editColumn('name', function ($affiliate) {
                $fullName = $affiliate->name;
                $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $affiliate->image . '"></a>';
                return $fullName ?? "N/A";
            })
            ->editColumn('email', function ($affiliate) {
                $email = valueOrEmptyString($affiliate->email, "N/A");
                return $email;
            })
            ->editColumn('mobile', function ($affiliate) {
                $mobile = valueOrEmptyString($affiliate->phone, "N/A");
                return $mobile;
            })
            ->editColumn('business', function ($affiliate) {
                return $affiliate->business ?? "N/A";
            })
            ->addColumn('logo', function ($affiliate) {
                // $logo = valueOrEmptyString(asset('affiliate_image/' . $affiliate->logo), "N/A");
                $profile = '<a class="avatar" href="javascript:void(0)"> <img alt="" class="img-fluid" src="' . $affiliate->logo. '"></a>';

                return  $profile;
            })
            ->addColumn('url', function ($affiliate) {
                if($affiliate->url ){ 
                    $url = '<span>' . $affiliate->url . '</span>';
                }
                else{
                    $url = 'N/A';
                }
                return $url;
            })         
            ->setRowClass('viewInformation')
            ->setRowAttr([
                'data-id' => function ($affiliate) {
                    return $affiliate->id;
                },
                'data-url' => function ($affiliate) {
                    return url("admin/Affiliate/" . $affiliate->id);
                },
            ])
            ->rawColumns(['logo' , 'url','name','email','mobile','business'])
            ->make(true);
    }


    public function index()
    {
        return view('admin.affiliationManagement.index');
    }

    public function create()
    {
        return "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        $affiliateData = $request->all();
        $image = $affiliateData['logo'];  // your base64 encoded
        if (! empty($image)) {
            if($image){
                $imageMainPath = 'affiliate_image/';
                if (!is_dir(public_path($imageMainPath))) {
                    mkdir(public_path($imageMainPath), 0777, true);
                }

                $profileImage = "affiliation-profile-" . time() . ".png";

                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);

                Storage::disk('public')->put($imageMainPath . $profileImage, base64_decode($image));

                $affiliateData['logo'] = $profileImage;
            } else {
                return redirect()->back()->with("danger", "Please select jpg, png, gif only");
            }
        }else{
           $affiliateData['logo'] = "";
        }
        AffiliationManagement::create($affiliateData);
        return redirect()->back()->with("success", "Partner details have been created successfully.");
    }*/

    public function store(Request $request)
    {
        // dd($request->all());
        $affiliateData = $request->all();

        $imageName = '';
        $imageUrl = '';
        $imageMainPath = 'affiliate_image/';
        if (!is_dir(public_path($imageMainPath))) {
            mkdir(public_path($imageMainPath), 0777, true);
        }

        if ($request->affimage != '') {
            $getImage = $request->affimage;
            $imageName = time().'.'.$getImage->extension();

            $uploadPath = public_path() . "/affiliate_image/" . $imageName;
            $images = str_replace('data:image/png;base64,', '', $request->logo);
            $cropimage = str_replace('', '+', $images);
            if (file_put_contents($uploadPath, base64_decode($cropimage))) {
                $imageUrl = url('/affiliate_image/' . $imageName);
                // dd($imageUrl);
                $affiliateData['logo'] = $imageUrl;
            }
        }
        // $affiliateData['logo'] = $imageName;

        if($request->url != ''){
            $affiliateData['url'] = $request->url;
        }
        AffiliationManagement::create($affiliateData);
        return redirect()->back()->with("success", "Affiliations added successfully.");
    }

    public function destroy($id)
    {
        $affiliate = AffiliationManagement::find($id);

        if ($affiliate) {
            $affiliate->delete();
            return response()->json(['success' => true]);
        } else {
            response()->with("error", "Opps!! Something went wrong. Please try again.");
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = "Affiliate";

        $affiliate = AffiliationManagement::where('id', $id)->first();
        if ($affiliate) {
            return view('admin.affiliationManagement.view', compact('affiliate', 'page'));
        } else {
            return view('admin.layouts.includes.modalError');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $affiliate = AffiliationManagement::find($id);
        $affiliateData = $request->all();
        // dd($affiliateData);

        if (!empty($affiliateData['logo'])) {
            if ($affiliateData['logo']) {
                $imageMainPath = 'affiliate_image/';
                if (!is_dir(public_path($imageMainPath))) {
                    mkdir(public_path($imageMainPath), 0777, true);
                }

                if ($affiliateData['logo'] != '') {
                    $getImage = $request->editimage;
                    $imageName = time().'.'.$getImage->extension();
                    $uploadPath = public_path() . "/affiliate_image/" . $imageName;
                    $images = str_replace('data:image/png;base64,', '', ($affiliateData['logo']));
                    $cropimage = str_replace('', '+', $images);
                    if (file_put_contents($uploadPath, base64_decode($cropimage))) {
                        $imageUrl = url('/affiliate_image/' . $imageName);
                        $affiliateData['logo'] = $imageUrl;
                    }
                }
            } else {

                return redirect()->back()->with("danger", "Please select jpg, png, gif only");
            }
        } else {

            unset($affiliateData['logo']);
        }
        if($request->url != ''){
            $affiliateData['url'] = $request->url;
        }

        $affiliate->update($affiliateData);
        return redirect()->back()->with("success", "Affiliations updated successfully.");
    }

    public function reorder(Request $request)
    {
        $posts = AffiliationManagement::all();
        // dd($posts);

        foreach ($posts as $post) {

            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    // dd($order['id']);
                    // dd($post);
                    $val = AffiliationManagement::find($post->id);
                    $val->update_reorder = $order['position'];
                    $val->save();  
                    
                }
            }
        }

        return response(['message' => 'Update Successfully'], 200);
    }
}
