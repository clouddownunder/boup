<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "FAQ’s";
        return view('admin.faqManagement.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $elementWithMaxOrder = Faq::orderBy('order', 'desc')->first();
        
        $maxOrder = 0;
        if ($elementWithMaxOrder) {
            $maxOrder = $elementWithMaxOrder->order;
        }

        // Increment the order value
        $request['order'] = $maxOrder + 1;
        $faq = Faq::create($request->all());
        if($faq){
            return Redirect::to('admin/faq-management')->with("success","FAQ created successfully !");
        }else{
            return redirect()->back()->with("error","Something wents wrong !");
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
        $page = "FAQ Details";
        $faq = Faq::find($id);
        if($faq){
            return view('admin.faqManagement.view', compact('faq','page'));
        }else{
            return view('admin.layouts.includes.modalError');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        if($faq->save()){
            return Redirect::to('admin/faq-management')->with("success","FAQ updated successfully !");
        }else{
            return redirect()->back()->with("error","Something wents wrong !");
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
        $faq = Faq::find($id);
        if($faq->delete()){
            return redirect(route('faq-management.index'))->with("success","FAQ deleted successfully !");
        }else{
            return redirect()->back()->with("error","Something wents wrong !");
        }
    }

    public function getAllFaq(){
        if(isset($_REQUEST['order'])){
            $faqs = Faq::orderBy('order','Asc')->get();
        }
        else{
            $faqs = Faq::orderBy('order','Asc')->get();
        }
        return DataTables::of($faqs)

                ->addIndexColumn()
                ->editColumn('question', function($faq){
                   return "<div style='word-break: break-word;' >". substr_replace($faq->question, "", 200)  ."</div>";
                })
                ->editColumn('answer', function($faq){
                   return "<div style='word-break: break-word;' > ". substr_replace($faq->answer, "...", 200) ."</div>";
                })
                ->rawColumns(['question','answer'])
                ->setRowClass('viewInformation')
                ->setRowAttr([
                    'data-id' => function($faq) {
                        return $faq->id;
                    },
                    'data-url' => function($faq) {
                        return url("admin/faq-management/".$faq->id);
                    },
                    'data-for' => function($faq) {
                        return 'all';
                    }
                ])
                ->make(true);
    }


    public function sortable(Request $request){
        // dd($request->order);
        $faqs = Faq::all();
        foreach ($faqs as $faq) {
            foreach ($request->order as $order) {
                if ($order['id'] == $faq->id) {
                    $faq->update(['order' => (int)$order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }
}
