@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="id" value="{{$patch->id}}">
<h2>补丁修改</h2>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >漏洞编号:</p> <input type="text" style="width:80%;" id="cnvd_id" class="form-control" value="{{$patch->cnvd_id}}" readonly="readonly">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >漏洞标题:</p> <input type="text" style="width:80%;" id="cnvd_title" class="form-control" value="{{$patch->cnvd->cnvd_title}}"  readonly="readonly">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >补丁信息:</p> <input type="text" style="width:80%;" id="patch_description" class="form-control" value="{{$patch->patch_description}}" placeholder="输入补丁信息">
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
        var patch_description=document.getElementById('patch_description').value;     
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../patchEditOk",
            data : {"id":id,
                    "patch_description":patch_description
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
                alert(err);
                alert("修改失败！！");
            }
        });
    }
</script>