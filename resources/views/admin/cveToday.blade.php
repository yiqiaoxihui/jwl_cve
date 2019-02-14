@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>最新漏洞更新</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th >ID</th>
                    <th>漏洞编号</th>
                    <th>漏洞状态</th>
                    <th>漏洞描述</th>
                    <th>参考数据库</th>
                    <th>phase</th>
                    <th>投票</th>
                    <th>评论</th>
                    <!-- <th>更新时间</th> -->
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($cves as $cve)
                <tr>
                    <td >{{$cve->id}}</td>
                    <td style="max-width:160px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">{{$cve->cve_id}}</td>
                    <td >{{$cve->cve_status}}</td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><div title="{{$cve->cve_description}}"> {{$cve->cve_description}}</div></td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><div title="{{$cve->cve_references}}"> {{$cve->cve_references}}</div></td>
                    <td style="max-width:180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><div title="{{$cve->cve_phase}}"> {{$cve->cve_phase}}</div></td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><div title="{{$cve->cve_votes}}"> {{$cve->cve_votes}}</div></td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><div title="{{$cve->cve_comments}}">{{$cve->cve_comments}}</div></td>
<!--                     <td style="max-width:120px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        {{$cve->created_at}}
                    @if($cve->status===1)
                    <span style="color: #5cb85c">监控中</span>
                    @elseif($cve->status===0)
                     <span style="color: #5bc0de">已停止</span>
                    @else
                    <span style="color: #d9534f">故障</span>
                    @endif
                    </td> -->

                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <button class="btn btn-primary"type="button" onclick="cve_edit({{$cve->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="cve_delete({{$cve->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" id="cve_id" style="height:34px;" placeholder="请输入cve编号"></td>
                    <td>
                        <input type="text" class="form-control" id="cve_status" placeholder="请输入cve状态">
                    </td>
                    <td ><input type="text" class="form-control" id="cve_description" placeholder="请输入cve描述"></td>
                    <td><input type="text" class="form-control" id="cve_references" placeholder="请输入参考数据库"></td>
                    <td><input type="text" class="form-control" id="cve_phase" placeholder="请输入phase"></td>
                    <td><input type="text" class="form-control" id="cve_votes" placeholder="请输入投票"></td>
                    <td><input type="text" class="form-control" id="cve_comments" placeholder="请输入评论"></td>
                    <!-- <td></td> -->
                    <!-- <td></td> -->
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()" id="pid" >添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $cves->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function addone(){
        var cve_id=document.getElementById('cve_id').value;
        var cve_status=document.getElementById('cve_status').value;
        var cve_references=document.getElementById('cve_references').value;
        var cve_description=document.getElementById('cve_description').value;
        var cve_votes=document.getElementById('cve_votes').value;
        var cve_comments=document.getElementById('cve_comments').value;
        var cve_phase=document.getElementById('cve_phase').value;
        console.log(cve_id);
        $.ajax({
            type: 'post',
            url : "../addCve",
            data : {"cve_id":cve_id,
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
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                // var str=err.responseText;
                // var obj=JSON.parse(str);
                // console.log(obj);
                // console.log(obj.name[0]);
                // console.log(err);
                var obj_json=err.responseJSON;
                //console.log(obj_json.name[0]);
                for(key in obj_json){
                    var id="#"+key;
                    layer.tips(obj_json[key], id, {
                      tips: 3,
                      tipsMore: true,
                      time: 5000,
                    });
                    console.log(id+":"+obj_json[key]);
                }
                layer.msg('请按要求输入！');
            }

        });
        // for(key in response){
        //     console.log(key+":"+response[key]);
        // }
    }
    function cve_edit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['500px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: '../cveEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "../cveDelete",
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
    function cve_delete(id){
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