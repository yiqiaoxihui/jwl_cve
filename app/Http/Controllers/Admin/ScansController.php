<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Virus;
use App\VirusKill;
use App\Scan;
use App\Rule;
class ScansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scanControl()
    {
        $rules=Rule::orderBy('id','asc')->paginate(4);
        return view('admin/scanControl',['rules'=>$rules]);
    }   

    public function newScan($id)
    {
        $rule = Rule::find($id);
        return view('admin/newScan',['rule'=>$rule]);
    }
    public function launchScanOk(Request $request)
    {
        $this->validate($request, [
            'rule_id' => 'required'
        ]);
        $info['status']=1;
        $scan=new Scan;
        $scan->rule_id = $request->get('rule_id');
        $scan->host = $request->get('host');
        $scan->status = "0";
        if ($scan->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('发起失败!!!');
        }  
    }  
    public function scanRecord()
    {
        $scans=Scan::orderBy('id','asc')->paginate(9);
        return view('admin/scanRecord',['scans'=>$scans]);
    }
    public function scanDelete(Request $request){
        $info['status']=1;
        Scan::destroy($request->get('id'));
        return json_encode($info);
    }






    public function virusAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'hash' => 'required'
        ]);
        $virus = new Virus;
        $virus->code = $request->get('code');
        $virus->name = $request->get('name');
        $virus->hash = $request->get('hash');

        if ($virus->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function virusEdit($id)
    {
        $virus = Virus::find($id);

        return view('admin/virusEdit',['virus'=>$virus]);
    }
    public function virusEditOk(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'hash' => 'required'
        ]);
        $info['status']=1;
        $virus = Virus::find($request->get('id'));
        $virus->code = $request->get('code');
        $virus->name = $request->get('name');
        $virus->hash = $request->get('hash');
        if ($virus->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function virusDelete(Request $request){
        $info['status']=1;
        Virus::destroy($request->get('id'));
        return json_encode($info);
    }
    public function virusRecord()
    {
        $virusRecords=virusKill::orderBy('id','asc')->paginate(9);
        return view('admin/virusRecord',['virusRecords'=>$virusRecords]);
    }
    public function virusRecordDelete(Request $request){
        $info['status']=1;
        VirusKill::destroy($request->get('id'));
        return json_encode($info);
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
