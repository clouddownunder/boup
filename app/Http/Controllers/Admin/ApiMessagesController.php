<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\DataTables;

class ApiMessagesController extends Controller
{
    public function index()
    {
        return view('admin.ApiMessages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        try {
            $path = App::langPath() . '/en/api.php';
            $api = Lang::get('api');
            if ($key == $request->name && array_key_exists($key, $api)) {
                $api[$key] = $request->message;
            }
            $output = "<?php\n\nreturn " . var_export($api, true) . ";\n";
            $f = new Filesystem();
            $f->put($path, $output);
            return redirect()->route('ApiMessages.index')->with("success", "Message updated successfully !");
        } catch (Exception $e) {
            return redirect()->route('ApiMessages.index')->with("error", "Something went wrong!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $page = "API Messages Details";
        $api = Lang::get('api');
        $apiMessage = [];
        if(array_key_exists($key,$api)) {
            $apiMessage['name'] = $key;
            $apiMessage['message'] = $api[$key];
        }
        if(! empty($apiMessage)) {
            return view('admin.ApiMessages.view', compact('apiMessage','page'));
        }else{
            return view('admin.layouts.includes.modalError');
        }
    }

    public function getalldata()
    {
        $api = Lang::get('api');
        $apiMessages = [];
        $i = 0;
        foreach ($api as $key => $value) {
            $apiMessages[$i]['name'] = $key;
            $apiMessages[$i]['messages'] = $value;
            $i++;
        }
        return DataTables::of($apiMessages)
            ->addIndexColumn()
            ->editColumn('name', function($apiMessages) {
                return $apiMessages['name'];
            })
            ->editColumn('messages', function($apiMessages) {
                return $apiMessages['messages'];
            })
            ->setRowClass('viewInformation')
            ->setRowAttr([
                'data-id' => function($apiMessages) {
                    return $apiMessages['name'];
                },
                'data-url' => function($apiMessages) {
                    return url("/admin/api-messages/".$apiMessages['name']);
                },
            ])
            ->rawColumns(['name','messages'])
            ->make(true);
    }

}
