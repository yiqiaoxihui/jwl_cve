@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>CNVD漏洞库</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th >ID</th>
                    <th>漏洞编号</th>
                    <th>漏洞标题</th>
                    <th>漏洞描述</th>
                    <th>危害级别</th>
                    <th>影响产品</th>
                    <th>补丁</th>
                    <th>提交时间</th>
                    <!-- <th>更新时间</th> -->
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($cnvds as $cnvd)
                <tr>
                    <td >{{$cnvd->id}}</td>
                    <td style="max-width:160px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">{{$cnvd->cnvd_id}}</td>
                    <td >{{$cnvd->cnvd_title}}</td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$cnvd->cnvd_description}}"> {{$cnvd->cnvd_description}}</div>
                    </td>
                    <td > 
                        @if($cnvd->cnvd_serverity==="低")
                        <span style="color: #5cb85c">低</span>
                        @elseif($cnvd->cnvd_serverity==="中")
                         <span style="color: #FFE600">中</span>
                        @else
                        <span style="color: #d9534f">高</span>
                        @endif
                    </td>
                    <td style="max-width:180px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$cnvd->cnvd_products}}"> {{$cnvd->cnvd_products}}</div>
                    </td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$cnvd->cnvd_formalWay}}"> {{$cnvd->cnvd_formalWay}}</div>
                    </td>
                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <div title="{{$cnvd->cnvd_submitTime}}">{{$cnvd->cnvd_submitTime}}</div>
                    </td>

                    <td style="max-width:200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">
                        <button class="btn btn-primary"type="button" onclick="cnvd_edit({{$cnvd->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="cnvd_delete({{$cnvd->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" id="cnvd_id" style="height:34px;" placeholder="请输入cnvd编号"></td>
                    <td>
                        <input type="text" class="form-control" id="cnvd_title" placeholder="请输入cnvd漏洞标题">
                    </td>
                    <td ><input type="text" class="form-control" id="cnvd_description" placeholder="请输入漏洞描述"></td>
                    <td><input type="text" class="form-control" id="cnvd_serverity" placeholder="危害级别：高/低/中"></td>
                    <td><input type="text" class="form-control" id="cnvd_products" placeholder="请输入影响产品"></td>
                    <td><input type="text" class="form-control" id="cnvd_formalWay" placeholder="请输入补丁链接"></td>
                    <td><input type="text" class="form-control" id="cnvd_submitTime" placeholder="提交时间"></td>
                    <!-- <td></td> -->
                    <!-- <td></td> -->
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()" id="pid" >添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $cnvds->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function addone(){
        var cnvd_id=document.getElementById('cnvd_id').value;
        var cnvd_title=document.getElementById('cnvd_title').value;
        var cnvd_description=document.getElementById('cnvd_description').value;
        var cnvd_serverity=document.getElementById('cnvd_serverity').value;
        var cnvd_products=document.getElementById('cnvd_products').value;
        var cnvd_formalWay=document.getElementById('cnvd_formalWay').value;
        var cnvd_submitTime=document.getElementById('cnvd_submitTime').value;
        console.log(cnvd_id);
        $.ajax({
            type: 'post',
            url : "addCnvd",
            data : {"cnvd_id":cnvd_id,
                    "cnvd_title":cnvd_title,
                    "cnvd_submitTime":cnvd_submitTime,
                    "cnvd_description":cnvd_description,
                    'cnvd_serverity':cnvd_serverity,
                    'cnvd_products':cnvd_products,
                    'cnvd_formalWay':cnvd_formalWay
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
    function cnvd_edit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['500px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'cnvdEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "cnvdDelete",
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
    function cnvd_delete(id){
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