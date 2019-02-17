@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>规则库管理</h2>
<!--     <div style="position: relative;margin-left: 30px;">
        <label>服务器</label>
        <select class="form-control" id="server_select_choose" onchange="serverChangeChoose()" style="display: inline;width: 400px;">
            <option value="0">-全部-</option>
        @foreach ($servers as $server)
            <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
        @endforeach
        </select>
        <label style="margin-left: 30px;"t>基础镜像</label>
        <select class="form-control" id="base_select_choose" onchange="baseChangeChoose()" style="display:inline;width: 400px;">
            
        </select>
        <label style="margin-left: 30px;">增量镜像</label>
        <select class="form-control" id="overlay_select_choose" onchange="overlayChangeChoose()" style="display:inline;width: 400px;">
        </select>
    </div> -->
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>规则名称</th>
                    <th width="9%">规则描述</th>
                    <th width="6%">规则参数</th>
                    <th width="6%">规则端口</th>
                    <th width="7%">对应漏洞</th>
                    <th>创建时间</th>
                    <th>修改时间</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($rules as $rule)
                <tr >
                    <td >
                        {{$rule->script_name}}
                    </td>
                    <td >{{$rule->script_descrption}}</td>
                    <td >
                    {{$rule->script_argv}}
                    </td>
                    <td >{{$rule->port}}</td>
                    <td >{{$rule->cve_id}}</td>
                    <td >{{$rule->createTime}}</td>
                    <td >{{$rule->modifyTime}}</td>
                    <td width="14%">
                        <button class="btn btn-primary"type="button" onclick="cve_edit({{$rule->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="cve_delete({{$rule->id}})">删除
                        </button>
                        <button class="btn btn-info" type="button" onclick="ruleStart({{$rule->id}})">扫描</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><input type="text" id="script_name" style="height:34px;" placeholder="请输入规则名称"></td>
                    <td>
                        <input type="text" class="form-control" id="script_descrption" placeholder="请输入规则描述">
                    </td>
                    <td ><input type="text" class="form-control" id="script_argv" placeholder="请输入规则参数"></td>
                    <td><input type="text" class="form-control" id="port" placeholder="请输入规则端口"></td>
                    <td><input type="text" class="form-control" id="cve_id" placeholder="请输入对于cve id"></td>
                    <td></td>
                    <td></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="ruleAdd()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $rules->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function ruleAdd(){
        var script_name=document.getElementById('script_name').value;
        var script_descrption=document.getElementById('script_descrption').value;
        var script_argv=document.getElementById('script_argv').value;
        var port=document.getElementById('port').value;
        var cve_id=document.getElementById('cve_id').value;
        // var overlayId=$('#overlay_select option:selected').val();
        console.log(overlayId);
        $.ajax({
            type: 'post',
            url : "{{url("rule/ruleAdd")}}",
            data : {"script_name":script_name,"script_descrption":script_descrption,"script_argv":script_argv,"port":port,"cve_id":cve_id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入！');
            }
        });
    }
    function ruleEdit(id){
        //console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'ruleEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("rule/ruleDelete")}}",
                data : {"id":id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data.status==1){
                        layer.msg("删除成功！");
                        location.reload(true);
                   }
                },
                error : function(err) {
                    layer.msg('删除失败！');
                }

            });
    }
    function ruleDelete(id){
        layer.msg('确定删除？', {
          time: 0 //不自动关闭
          ,btn: ['删除', '取消']
          ,yes: function(index){
            Delete(id);
            layer.close(index);
            // layer.msg('删除成功！', {
            //   icon: 6
            //   ,btn: ['关闭']
            // });
          }
        });
    }
    function ruleScan(id){
        $.ajax({
            type: 'post',
            url : "{{url("rule/ruleScan")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("发起扫描成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('scan error!!!');
            }
        });
    }
    function ruleStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("rule/ruleStop")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("停止成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('boot error!!!');
            }
        });
    }



</script>