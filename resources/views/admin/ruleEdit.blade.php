@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="id" value="{{$rule->id}}">
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >规则名称:</p> <input type="text" style="width:80%;" id="script_name" class="form-control" value="{{$rule->script_name}}" placeholder="请输入规则名称">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >规则描述:</p> <input type="text" style="width:80%;" id="script_descrption" class="form-control" value="{{$rule->script_descrption}}" placeholder="规则描述">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >规则参数:</p> <input type="text" style="width:80%;" id="script_argv" class="form-control" value="{{$rule->script_argv}}" placeholder="请输入规则参数">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >端口:</p> <input type="text" style="width:80%;" id="port" class="form-control" value="{{$rule->port}}" placeholder="请输入规则端口">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >匹配值:</p> <input type="text" style="width:80%;" id="reg" class="form-control" value="{{$rule->reg}}" placeholder="请输入匹配值">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >对应cve id:</p> <input type="text" style="width:80%;" id="cve_id" class="form-control" value="{{$rule->cve_id}}" placeholder="请输入对应cve id">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引

    function editone(){
        var id=document.getElementById('id').value;
        var script_name=document.getElementById('script_name').value;
        var script_descrption=document.getElementById('script_descrption').value;
        var script_argv=document.getElementById('script_argv').value;
        var port=document.getElementById('port').value;
        var reg=document.getElementById('reg').value;
        var cve_id=document.getElementById('cve_id').value;     
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../ruleEditOk",
            data : {"id":id,
                    "script_name":script_name,
                    "script_descrption":script_descrption,
                    "port":port,
                    "script_argv":script_argv,
                    'cve_id':cve_id,
                    'reg':reg
                },
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    parent.layer.msg('修改成功');
                    parent.location.reload(true);
                    parent.layer.close(index);

               }
            },
            error : function(err) {
                alert("修改失败！！");
            }
        });
    }
</script>