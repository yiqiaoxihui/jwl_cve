@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>补丁库管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th >ID</th>
                    <th>漏洞编号</th>
                    <th>漏洞标题</th>
                    <th style="width: 55%;">补丁信息</th>
                    <!-- <th>提交时间</th> -->
                    <!-- <th>更新时间</th> -->
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($patchs as $patch)
                <tr>
                    <td >{{$patch->id}}</td>
                    <td style="max-width:160px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">{{$patch->cnvd_id}}</td>
                    <td >
                        @if($patch->cnvd)
                        {{$patch->cnvd->cnvd_title}}
                        @else
                        未知
                        @endif
                    </td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$patch->patch_description}}"> {{$patch->patch_description}}</div>
                    </td>
<!--                     <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$patch->patch_submitTime}}">{{$patch->patch_submitTime}}</div>
                    </td> -->
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <button class="btn btn-primary"type="button" onclick="patch_edit({{$patch->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="patch_delete({{$patch->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">{!! $patchs->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function patch_edit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['500px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'patchEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "patchDelete",
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
    function patch_delete(id){
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
</script>