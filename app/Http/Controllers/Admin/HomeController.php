<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server;
use App\Cve;
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
