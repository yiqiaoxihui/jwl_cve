<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incomesource;
use App\Incomeaccumulate;
use App\Incomesum;
use App\File;
use App\Overlay;
use App\Server;
use App\BaseImage;
use App\FileRestore;
use App\FileRestoreRecord;
use App\FileScanRecord;
use App\Rule;
use App\Scan;
class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function rule()
    {
        $rules=Rule::orderBy('id','asc')->paginate(5);
        return view('admin/rule',['rules'=>$rules]);
    }

    public function ruleAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'script_name' => 'required|max:255',
            'script_descrption' => 'required'
        ]);

        $rule = new Rule;
        $rule->cve_id = $request->get('cve_id');
        $rule->script_name = $request->get('script_name');
        $rule->script_descrption = $request->get('script_descrption');
        $rule->script_argv = $request->get('script_argv');
        $rule->port = $request->get('port');
        $rule->reg = $request->get('reg');
        if ($rule->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function ruleDelete(Request $request){
        $info['status']=1;
        Rule::destroy($request->get('id'));
        return json_encode($info);
    }
    public function ruleEdit($id)
    {
        $rule = Rule::find($id);
        return view('admin/ruleEdit',['rule'=>$rule]);
    }
    public function ruleEditOk(Request $request)
    {
        $this->validate($request, [
            'id'=>'required',
            'script_name' => 'required|max:255',
            'script_descrption' => 'required'
        ]);
        $info['status']=1;
        $rule = Rule::find($request->get('id'));
        $rule->cve_id = $request->get('cve_id');
        $rule->script_name = $request->get('script_name');
        $rule->script_descrption = $request->get('script_descrption');
        $rule->script_argv = $request->get('script_argv');
        $rule->port = $request->get('port');
        $rule->reg = $request->get('reg');
        if ($rule->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
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
    /********************************old**********************************/
    public function fileScan(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->status=1;
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('boot failed!');
        }
    }
    
    public function fileStop(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->status=0;
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('stop failed!');
        }
    }
    public function fileRestoreInfo(){
        $fileRestores=FileRestore::Orderby('created_at','desc')->paginate(9);
        return view("admin/fileRestore",['fileRestores'=>$fileRestores]);
    }
    //文件还原：将file.restore=1,添加一条待还原记录
    public function fileRestore(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=1;
        $fileRestore=new FileRestore;
        $fileRestore->fileId=$request->get('id');
        if($file->isModified==1){
            $fileRestore->restoreReason=1;
        }
        if($file->lost==1){
            $fileRestore->restoreReason=2;
        }
        if($file->isModified==1 && $file->lost==1){
            $fileRestore->restoreReason=3;
        }
        $fileRestore->restoreStatus=0;
        if($file->save() && $fileRestore->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileRestore failed!');
        }
        
    }
    public function fileRestoreCancel(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=0;
        FileRestore::destroy($file->fileRestore->id);
        //$fileRestore=FileRestore::where("fileId",$file->id)
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileRestoreCancel failed!');
        }
    }
    public function fileReset(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=0;
        $file->isModified=0;
        $file->lost=0;
        //$fileRestore=FileRestore::where("fileId",$file->id)
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileReset failed!');
        }
    }
    public function fileRestoreRecord()
    {
        $servers=Server::select("id","name")->get();
        $fileRestoreRecords=fileRestoreRecord::Orderby('created_at','desc')->paginate(9);
        return view("admin/fileRestoreRecord",['fileRestoreRecords'=>$fileRestoreRecords,'servers'=>$servers]);
    }
    public function fileRestoreRecordChoose($overlay_id){
        $id=$overlay_id;
        $servers=Server::select("id","name")->get();
        // $fileRestoreRecords=DB::table('fileRestoreRecord')->join('files','files.id','=','fileRestoreRecord.fileId')->join('overlays','overlays.id','=','files.overlayId')->where('overlays.id',$id)->paginate(9);
        $overlay=Overlay::find($id);
        $fileRestoreRecords=$overlay->fileRestoreRecords()->paginate(9);
        //echo $fileRestoreRecords;
        return view("admin/fileRestoreRecord",['fileRestoreRecords'=>$fileRestoreRecords,'servers'=>$servers]);
    }
    public function fileScanStart(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $overlay=Overlay::find($request->get('id'));
        $overlay->scan=1;
        if($overlay->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('scan start failed!');
        }
    }
    
    public function fileScanStop(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $overlay=Overlay::find($request->get('id'));
        $overlay->scan=0;
        if($overlay->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('scan stop failed!');
        }
    }
    public function fileScanRecord()
    {
        $fileScanRecords=FileScanRecord::Orderby('created_at','desc')->paginate(9);
        return view("admin/fileScanRecord",['fileScanRecords'=>$fileScanRecords]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
