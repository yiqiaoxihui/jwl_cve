<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server;
use App\Cve;
use App\Cnvd;
use App\FileRestoreRecord;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //var $fileRestoreRecord_count=0;
    /*****************************************************************************/
    public function fileRestoreNew(Request $request){
        $fileRestoreRecords=FileRestoreRecord::where('message','0')->paginate(9);
        FileRestoreRecord::where('message','0')->update(['message'=>1]);
        //$request->session()->put('fileRestoreRecord_count',0);
        return view('admin/fileRestoreNew',['fileRestoreRecords'=>$fileRestoreRecords]);
    }
    public function index(Request $request)
    {
        $cves= Cve::Orderby('id','asc')->paginate(5);
        return view('admin/index',['cves'=>$cves]);
    }
    public function cve_today(Request $request)
    {
        $last_cve=Cve::Orderby('id','desc')->first();
        $last_cve_id=$last_cve->id;
        $cves= Cve::where('id','>',$last_cve_id-20)->Orderby('id','desc')->paginate(5);
        return view('admin/cveToday',['cves'=>$cves]);
    }
    public function cve_add(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'cve_id' => 'required|max:20',
            'cve_status' => 'required|max:100',
            'cve_references' => 'required',
            'cve_description' => 'required',  
        ]);

        $cve = new Cve;
        $cve->cve_id = $request->get('cve_id');
        $cve->cve_status = $request->get('cve_status');
        $cve->cve_description = $request->get('cve_description');
        $cve->cve_references = $request->get('cve_references');
        $cve->cve_phase = $request->get('cve_phase');
        $cve->cve_votes = $request->get('cve_votes');
        $cve->cve_comments = $request->get('cve_comments');
        if ($cve->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }

    public function cve_edit($id)
    {
        $cve=Cve::find($id);
        return view('admin/cveEdit',['cve'=>$cve]);
    }

    public function cve_edit_ok(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'cve_id' => 'required|max:20',
            'cve_status' => 'required|max:100',
            'cve_references' => 'required',
            'cve_description' => 'required', 
        ]);
        $info['status']=1;
        $cve = Cve::find($request->get('id'));
        $cve->cve_id = $request->get('cve_id');
        $cve->cve_status = $request->get('cve_status');
        $cve->cve_description = $request->get('cve_description');
        $cve->cve_references = $request->get('cve_references');
        $cve->cve_phase = $request->get('cve_phase');
        $cve->cve_votes = $request->get('cve_votes');
        $cve->cve_comments = $request->get('cve_comments');
        if ($cve->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function cve_delete(Request $request){
        $info['status']=1;
        Cve::destroy($request->get('id'));

        //echo $status;
        return json_encode($info);
    }


    /********************cnvd********************/
    public function cnvd(Request $request)
    {
        $cnvds= Cnvd::Orderby('id','asc')->paginate(5);
        return view('admin/cnvd',['cnvds'=>$cnvds]);
    }
    public function cnvd_today(Request $request)
    {
        $last_cnvd=Cnvd::Orderby('id','desc')->first();
        $last_cnvd_id=$last_cnvd->id;
        $cnvds= Cnvd::where('id','>',$last_cnvd_id-20)->Orderby('id','desc')->paginate(5);
        return view('admin/cnvdToday',['cnvds'=>$cnvds]);
    }
    public function cnvd_add(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'cnvd_id' => 'required|max:20',
            'cnvd_title' => 'required',
            'cnvd_description' => 'required',
            'cnvd_serverity' => 'required',  
        ]);

        $cnvd = new Cnvd;
        $cnvd->cnvd_id = $request->get('cnvd_id');
        $cnvd->cnvd_title = $request->get('cnvd_title');
        $cnvd->cnvd_description = $request->get('cnvd_description');
        $cnvd->cnvd_serverity = $request->get('cnvd_serverity');
        $cnvd->cnvd_products = $request->get('cnvd_products');
        $cnvd->cnvd_formalWay = $request->get('cnvd_formalWay');
        $cnvd->cnvd_submitTime = $request->get('cnvd_submitTime');
        if ($cnvd->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }

    public function cnvd_edit($id)
    {
        $cnvd=Cnvd::find($id);
        return view('admin/cnvdEdit',['cnvd'=>$cnvd]);
    }

    public function cnvd_edit_ok(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'cnvd_id' => 'required|max:20',
            'cnvd_title' => 'required',
            'cnvd_description' => 'required',
            'cnvd_serverity' => 'required',  
        ]);
        $info['status']=1;
        $cnvd = Cnvd::find($request->get('id'));
        $cnvd->cnvd_id = $request->get('cnvd_id');
        $cnvd->cnvd_title = $request->get('cnvd_title');
        $cnvd->cnvd_description = $request->get('cnvd_description');
        $cnvd->cnvd_serverity = $request->get('cnvd_serverity');
        $cnvd->cnvd_products = $request->get('cnvd_products');
        $cnvd->cnvd_formalWay = $request->get('cnvd_formalWay');
        $cnvd->cnvd_submitTime = $request->get('cnvd_submitTime');
        if ($cnvd->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
    }
    public function cnvd_delete(Request $request){
        $info['status']=1;
        Cnvd::destroy($request->get('id'));
        //echo $status;
        return json_encode($info);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

