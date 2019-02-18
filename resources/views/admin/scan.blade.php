@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>扫描列表</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>编号</th>
                    <th>扫描目标</th>
                    <th >扫描类型</th>
                    <th style="overflow: hidden;width: 35%;">描述</th>
                    <th >对应漏洞</th>
                    <th >扫描状态</th>
                    <th >扫描结果</th>
                    <th>创建时间</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($scans as $scan)
                <tr >
                    <td>
                        {{$scan->id}}
                    </td>
                    <td>
                        {{$scan->host}}
                    </td>
                    <td >
                        {{$scan->rule->script_name}}
                    </td>
                    <td >{{$scan->rule->script_descrption}}</td>
                    <td >
                    {{$scan->rule->cve_id}}
                    </td>
                    <td >
                        @if($scan->status=="0")
                        <span style="color: #5cb85c">待扫描</span>
                        @elseif($scan->status=="1")
                        <span style="color: #5bc0de">扫描完成</span>
                        @else
                        <span style="color: #d9534f">扫描失败</span>
                        @endif
                        
                    </td>

                    <td >{{$scan->scan_result}}</td>
                    <td >{{$scan->created_at}}</td>
                    <td width="14%">
                        <button class="btn btn-danger"type="button" onclick="scan_result_delete({{$scan->id}})">删除</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">{!! $scans->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("scan/scanDelete")}}",
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
    function scan_result_delete(id){
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