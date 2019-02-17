@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="id" value="{{$cve->id}}">
<input type="text" name="cve_id" id="cve_id" class="form-control" value="{{$cve->cve_id}}" placeholder="cve 编号">
<br>
<input name="cve_status" id="cve_status"class="form-control" value="{{$cve->cve_status}}" placeholder="cve 状态">
<br>
<input name="cve_description" id="cve_description"class="form-control" value="{{$cve->cve_description}}" placeholder="cve description">
<br>
<input name="cve_references" id="cve_references"class="form-control" value="{{$cve->cve_references}}" placeholder="cve references">
<br>
<input name="cve_phase" id="cve_phase"class="form-control" value="{{$cve->cve_phase}}" placeholder="cve phase">
<br>
<input name="cve_votes" id="cve_votes"class="form-control" value="{{$cve->cve_votes}}" placeholder="cve votes">
<br>
<input name="cve_comments" id="cve_comments"class="form-control" value="{{$cve->cve_comments}}" placeholder="cve comments">
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
        var cve_id=document.getElementById('cve_id').value;
        var cve_status=document.getElementById('cve_status').value;
        var cve_description=document.getElementById('cve_description').value;
        var cve_references=document.getElementById('cve_references').value;
        var cve_phase=document.getElementById('cve_phase').value;
        var cve_votes=document.getElementById('cve_votes').value;
        var cve_comments=document.getElementById('cve_comments').value;        
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../cveEditOk",
            data : {"id":id,
                    "cve_id":cve_id,
                    "cve_status":cve_status,
                    "cve_references":cve_references,
                    "cve_description":cve_description,
                    'cve_votes':cve_votes,
                    'cve_comments':cve_comments,
                    'cve_phase':cve_phase
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