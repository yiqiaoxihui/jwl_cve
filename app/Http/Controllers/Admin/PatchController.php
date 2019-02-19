<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Server;
use App\Cve;
use App\Cnvd;
use App\Patch;
use App\FileRestoreRecord;
class PatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /********************patch********************/
    public function patch(Request $request)
    {
        $patchs= Patch::Orderby('id','asc')->paginate(5);
        return view('admin/patch',['patchs'=>$patchs]);
    }
    public function patch_add(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'cnvd_id' => 'required|max:20',
            'patch_description' => 'required',
        ]);

        $patch = new Patch;
        $patch->cnvd_id = $request->get('cnvd_id');
        $patch->patch_description = $request->get('patch_description');
        if ($cnpatchvd->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }

    public function patch_edit($id)
    {
        $patch=Patch::find($id);
        return view('admin/patchEdit',['patch'=>$patch]);
    }

    public function patch_edit_ok(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'patch_description' => 'required',
        ]);
        $info['status']=1;
        $patch = Patch::find($request->get('id'));
        $patch->patch_description = $request->get('patch_description');
        if ($patch->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
    }
    public function patch_delete(Request $request){
        $info['status']=1;
        Patch::destroy($request->get('id'));
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

