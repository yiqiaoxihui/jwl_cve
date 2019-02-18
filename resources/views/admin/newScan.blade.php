@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="rule_id" value="{{$rule->id}}">
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >扫描类型:</p> <input type="text" style="width:80%;" id="rule_id" class="form-control" value="{{$rule->script_name}}" placeholder="">
<br>
<p style ="float: left;margin-top:5px;margin-right: 5px;width: 80px;" >扫描目标:</p> <input type="text" style="width:80%;" id="host" class="form-control" value="" placeholder="请输入扫描目标（无目标扫描请忽略）">
<br>
<button class="btn btn-default" onclick="launch_scan()" >发起扫描</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引

    function launch_scan(){
        var rule_id=document.getElementById('rule_id').value;
        var host=document.getElementById('host').value;  
        console.log(rule_id);
        $.ajax({
            type: 'post',
            url : "../launchScanOk",
            data : {"rule_id":rule_id,
                    "host":host
                },
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    parent.layer.msg('发起扫描成功,请转到扫描页查看！');
                    parent.location.reload(true);
                    parent.layer.close(index);

               }
            },
            error : function(err) {
                alert("发起失败！");
            }
        });
    }
</script>