@extends('layouts.app')

@section('title', 'Home')

@section('styles')
    {!! Html::style('css/star-rating.min.css') !!}
@endsection

@section('content')

<?php
    include(app_path().'/Included/GetTarget.php');
    $instance = null;

    if(count($targets)>0){
        $count = 0;
        foreach($targets as $target){
            $instance = new GetTarget($target->vuforia_target_id);
            $result = json_decode($instance->result);
            $result =  json_decode(json_encode($result), true);
            $ListTargets[$count] = $result;
            $target = \App\Target::where('vuforia_target_id',$target->vuforia_target_id)->update(['recos' => $ListTargets[$count]['total_recos']]);
            $count++;
        }
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Request::segment(1) == 'getusertarget' ? $user->name.'的廣告' : '您的廣告'}}
                    <a class="btn pull-right" style="padding: 0px 10px;margin-left:15px;" onclick="window.location.reload()">
                        <i class="fa fa-refresh fa-lg"></i>
                    </a>
                    @if(Request::segment(1) == 'getusertarget')
                    <span class="pull-right"><a href="/admin"><b>[&nbsp;返回&nbsp;]</b></a></span>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table">

                        @if (count($targets) === 0)
                            <thead>
                            <td>還未新增廣告，請開始新增廣告</td>
                            </thead>
                        @elseif (count($targets) >= 1)
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>名稱</th>
                                <th>辨認程度</th>
                                <th>已辨識次數</th>
                                <th>可辨識次數</th>
                                <th>啟用狀態</th>
                                <th>狀態</th>
                                @can('isSuperAdmin',auth()->user())
                                <th>使用者</th>
                                @endcan
                                <th>操作</th>
                            </tr>
                            </thead>

                            @for($i=0;$i<count($ListTargets);$i++)
                                <tbody>
                                <tr>
                                    @if($ListTargets[$i]['status']=="success")
                                    <td><a href="{{Request::segment(1) == 'getusertarget' ? '/targets/'.$targets[$i]->vuforia_target_id.'/'.$targets[$i]->users_id : '/targets/'.$targets[$i]->vuforia_target_id}}">{!!Html::image($targets[$i]->image_path,'',['width'=>'50','height'=>'50']) !!}</a></td>
                                    <td><a href="{{Request::segment(1) == 'getusertarget' ? '/targets/'.$targets[$i]->vuforia_target_id.'/'.$targets[$i]->users_id : '/targets/'.$targets[$i]->vuforia_target_id}}">{{ $targets[$i]->name}}</a></td>
                                    @else
                                        <td>{!!Html::image($targets[$i]->image_path,'',['width'=>'50','height'=>'50']) !!}</td>
                                        <td>{{ $targets[$i]->name}}</td>
                                    @endif
                                    <td style="width:200px"><input id="rate" name="rating" class="rating" readonly="true" data-show-caption="false" data-show-clear="false" data-min="0" data-max="5" data-size="xs" value="{{$ListTargets[$i]['tracking_rating']}}"></td>
                                    <td>{{ $ListTargets[$i]['total_recos']}}</td>
                                    <td>{{ $targets[$i]->total_recos}}</td>
                                    <td>
                                        @if($ListTargets[$i]['active_flag'])
                                            <label>啟用</label>
                                        @elseif(!$ListTargets[$i]['active_flag'])
                                            <label>未啟用</label>
                                        @else
                                            <label>錯誤</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ListTargets[$i]['status']=="success")
                                            <label>成功</label>
                                        @elseif($ListTargets[$i]['status']=="processing")
                                            <label>處理中</label>
                                        @elseif($ListTargets[$i]['status']=="failure")
                                            失敗
                                        @else
                                            錯誤
                                        @endif
                                    </td>
                                    @can('isSuperAdmin',auth()->user())
                                    <td>{{$targets[$i]->user_name}}</td>
                                    @endcan
                                    <td>
                                        <form class="targetDeleteForm" id="targetDeleteForm" name="targetDeleteForm" action="/vuforia/vuforiaAction" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" class="form-control" name="select" id="select" value="DeleteTarget">
                                            <input type="hidden" class="form-control" name="targetId" id="targetId" value="{{ $targets[$i]->id}}">
                                            <input type="hidden" class="form-control" name="vuforiaTargetId" id="vuforiaTargetId" value="{{$targets[$i]->vuforia_target_id}}">
                                            @if($ListTargets[$i]['status']=="success")
                                            <button type="submit" class="btn btn-danger" id="deleteTargetSubmit" name="deleteTargetSubmit">刪除</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            @endfor
                        @endif
                    </table>
                    {!! $targets->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/star-rating.min.js') !!}
    <script>
        var url = '{{URL::previous()}}';
        var role_id = '{{auth()->user()->role_id}}';

        if(url == 'http://52.68.61.191/login' && (role_id == 3 || role_id ==2)) {
            window.location = "http://52.68.61.191/admin";
        }

        $('.targetDeleteForm').on('submit',(function(e){
            e.preventDefault();
            var currentForm = this;
            bootbox.dialog({
                title: '刪除廣告',
                message:'確認要刪除廣告?',
                onEscape:true,
                buttons:{
                    cancel: {
                        label: "取消",
                        className: "btn-danger"
                    },
                    confirm: {
                        label: "確認",
                        className: "btn-primary",
                        callback: function() {
                            currentForm.submit();
                        }
                    }
                },
            });
        }));
    </script>
@endsection