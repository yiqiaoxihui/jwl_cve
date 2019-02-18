@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>规则库管理</h2>

    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>ID</th>
                    <th>规则名称</th>
                    <th style="overflow: hidden;width: 35%;">规则描述</th>
                    <th width="">规则参数</th>
                    <th width="">规则端口</th>
                    <th width="">对应漏洞</th>
                    <th>匹配值</th>
                    <!-- <th>创建时间</th> -->
                    <!-- <th>修改时间</th> -->
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($rules as $rule)
                <tr > 
                    <td >
                        {{$rule->id}}
                    </td>
                    <td >
                        {{$rule->script_name}}
                    </td>
                    <td >{{$rule->script_descrption}}</td>
                    <td >
                      @if($rule->script_argv=="")
                        无
                      @else
                      {{$rule->script_argv}}
                      @endif
                    </td>
                    <td >
                      @if($rule->port=="")
                        无
                      @else
                      {{$rule->port}}
                      @endif
                    </td>
                    <td >
                      @if($rule->cve_id=="")
                        无
                      @else
                      {{$rule->cve_id}}
                      @endif
                    </td>
                    <td >
                      @if($rule->reg=="")
                        无
                      @else
                      {{$rule->reg}}
                      @endif
                    </td>
                    <!-- <td >{{$rule->createTime}}</td> -->
                    <!-- <td >{{$rule->modifyTime}}</td> -->
                    <td width="14%">
                        <button class="btn btn-primary"type="button" onclick="rule_edit({{$rule->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="rule_delete({{$rule->id}})">删除
                        </button>
                        <button class="btn btn-info" type="button" onclick="new_scan({{$rule->id}})">扫描</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td>添加</td>
                    <td ><input type="text" title="请输入规则名称" id="script_name" style="height:34px;" placeholder="请输入规则名称"></td>
                    <td>
                        <input type="text" title="请输入规则描述"  class="form-control" id="script_descrption" placeholder="请输入规则描述">
                    </td>
                    <td ><input type="text"  title="请输入规则参数" class="form-control" id="script_argv" placeholder="请输入规则参数"></td>
                    <td><input type="text"  title="请输入端口" class="form-control" id="port" placeholder="请输入端口"></td>
                    <td><input type="text"  title="请输入对应cve id" class="form-control" id="cve_id" placeholder="请输入对应cve id"></td>
                    <td><input type="text"  title="请输入匹配规则" class="form-control" id="reg" placeholder="请输入匹配规则"></td>
                    <!-- <td></td> -->
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
        var reg=document.getElementById('reg').value;
        var cve_id=document.getElementById('cve_id').value;
        // var overlayId=$('#overlay_select option:selected').val();
        // console.log(overlayId);
        $.ajax({
            type: 'post',
            url : "{{url("rule/ruleAdd")}}",
            data : {
                "script_name":script_name,
                "script_descrption":script_descrption,
                "script_argv":script_argv,
                "port":port,
                "reg":reg,
                "cve_id":cve_id
            },
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
    function rule_edit(id){
        //console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'rule/ruleEdit/'+id,
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
    function rule_delete(id){
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
    function new_scan(id){
        //console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'rule/newScan/'+id,
          cancel:function(index){
            location.reload(true);
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