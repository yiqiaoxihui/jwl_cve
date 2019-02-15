@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="id" value="{{$cnvd->id}}">
<input type="text" id="cnvd_id" class="form-control" value="{{$cnvd->cnvd_id}}" placeholder="cnvd 编号">
<br>
<input id="cnvd_title"class="form-control" value="{{$cnvd->cnvd_title}}" placeholder="cnvd标题">
<br>
<input id="cnvd_description"class="form-control" value="{{$cnvd->cnvd_description}}" placeholder="cnvd description">
<br>
<input id="cnvd_serverity"class="form-control" value="{{$cnvd->cnvd_serverity}}" placeholder="危害级别：高/低/中">
<br>
<input id="cnvd_products"class="form-control" value="{{$cnvd->cnvd_products}}" placeholder="影响产品">
<br>
<input id="cnvd_formalWay"class="form-control" value="{{$cnvd->cnvd_formalWay}}" placeholder="漏洞提交时间">
<br>
<input id="cnvd_submitTime"class="form-control" value="{{$cnvd->cnvd_submitTime}}" placeholder="漏洞提交时间">
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
        var cnvd_id=document.getElementById('cnvd_id').value;
        var cnvd_title=document.getElementById('cnvd_title').value;
        var cnvd_serverity=document.getElementById('cnvd_serverity').value;
        var cnvd_description=document.getElementById('cnvd_description').value;
        var cnvd_products=document.getElementById('cnvd_products').value;
        var cnvd_formalWay=document.getElementById('cnvd_formalWay').value;
        var cnvd_submitTime=document.getElementById('cnvd_submitTime').value;        
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../cnvdEditOk",
            data : {"id":id,
                    "cnvd_id":cnvd_id,
                    "cnvd_serverity":cnvd_serverity,
                    "cnvd_title":cnvd_title,
                    "cnvd_products":cnvd_products,
                    "cnvd_description":cnvd_description,
                    "cnvd_formalWay":cnvd_formalWay,
                    "cnvd_submitTime":cnvd_submitTime
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

// $('#test').on('click', function(){
//     parent.$('#pid').text('我被改变了');
//     parent.layer.tips('Look here', '#pid', {time: 5000});
//     parent.layer.close(index);
// });
// $('#new').click(function(){
//     parent.layer.msg('修改成功！！！');

//     parent.layer.close(index);
// });
// $('#modify').click(function(){

//     parent.layer.msg('修改成功');
//     parent.layer.close(index);
// });

    // function addone(){
    //     var ydate=document.getElementById('datetimepicker').value;
    //     var number=document.getElementById('number').value;
    //     console.log(ydate);
    //     $.ajax({
    //         type: 'post',
    //         url : "admin/addYktrend",
    //         data : {"ydate":ydate,"number":number},
    //         dataType:'JSON', 
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         },
    //         success : function(data) {
    //            if(data.status==1){
    //                 alert("添加成功！");
    //            }
    //         },
    //         error : function(err) {
    //             alert("添加失败"+err);
    //         }
    //     });
    // }
</script>