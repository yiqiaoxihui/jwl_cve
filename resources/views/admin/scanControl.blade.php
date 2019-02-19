@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>扫描控制面板</h2>

    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>ID</th>
                    <th>规则名称</th>
                    <th style="overflow: hidden;width: 50%;">规则描述</th>
                    <th width="">规则参数</th>
                    <th width="">规则端口</th>
                    <th width="">对应漏洞</th>
                    <!-- <th>匹配值</th> -->
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
<!--                     <td >
                      @if($rule->reg=="")
                        无
                      @else
                      {{$rule->reg}}
                      @endif
                    </td> -->
                    <!-- <td >{{$rule->createTime}}</td> -->
                    <!-- <td >{{$rule->modifyTime}}</td> -->
                    <td width="14%">
                        <button class="btn btn-info" type="button" onclick="new_scan({{$rule->id}})">发起扫描</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">{!! $rules->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function new_scan(id){
        //console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'newScan/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });
    }
</script>