@extends('layouts.app')

@section('title', 'Detail')

@section('styles')
    {!! Html::style('css/font-awesome.min.css') !!}
@endsection

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$targets->name}}
                        <span class="pull-right"><a href="{{Request::segment(3) == null ? '/' : '/getusertarget/'.$targets->users_id }}"><b>[&nbsp;返回&nbsp;]</b></a></span>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    {!!Html::image($targets->image_path,'',['width'=>'100%','height'=>'100%']) !!}
                                </div>
                                <div class="col-md-6">
                                    <form action="/vuforia/vuforiaAction" id="form" onsubmit='detailTargetSubmit.disabled = true;' method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" class="form-control" name="targetId" id="targetId" value="{{$targets->vuforia_target_id}}">
                                        <input type="hidden" class="form-control" name="recos" id="recos" value="{{$targets->recos}}">
                                        <input type="hidden" class="form-control" name="imageLocation" id="imageLocation" value="{{$targets->image_path}}">
                                        <input type="hidden" class="form-control" name="select" id="select" value="UpdateTarget">
                                            {!! Form::hidden('created_id', auth()->user()->id) !!}
                                            {!! Form::hidden('created_name', auth()->user()->name) !!}

                                        <div class="input-group">
                                            <label class="input-group-addon">名稱</label>
                                            <input class="form-control control" style="width:100%" type="text" name="name" value="{{ $targets->name}}">
                                        </div>
                                        <br/>

                                        <div class="input-group">
                                            <label class="input-group-addon" style="padding-right: 18px;">Y軸</label>
                                            <input class="form-control control" style="width:100%" type="number" name="y_coordinate" value="{{ $targets->y_coordinate}}">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <label class="input-group-addon" style="padding-right: 18px;">X軸</label>
                                            <input class="form-control control" style="width:100%" type="number" name="x_coordinate" value="{{ $targets->x_coordinate}}">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <label class="input-group-addon" style="padding-right: 18px;">可掃瞄次數</label>
                                            <input class="form-control control scan" style="width:100%" type="number" name="total_recos" value="{{ $targets->total_recos}}">
                                        </div>
                                        <br/>
                                        <button class="btn btn-primary pull-right" type="submit" name="detailTargetSubmit">更新</button>
                                    </form>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color:#9F6C5B;color:white">
                                            <b>影片來源</b>
                                            @if (count($targets_videos) === 0 && auth()->user()->id == $targets->users_id)
                                            <label class="pull-right"><u style="cursor: pointer" data-toggle="modal" data-target="#createTargetVideo">[&nbsp;新增影片&nbsp;]</u></label>
                                            @endif
                                        </div>
                                        <div class="panel-body">
                                            <div class="container-fluid">
                                                <table class="table">
                                                    @if (count($targets_videos) === 0)
                                                        <thead>
                                                        <td>還未新增影片，請開始新增影片</td>
                                                        </thead>
                                                    @elseif (count($targets_videos) >= 1)
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            @if(auth()->user()->id == $targets->users_id)
                                                            <th>操作</th>
                                                            @endif
                                                        </tr>
                                                        </thead>
                                                        @foreach($targets_videos as $targets_video)
                                                            <tbody>
                                                            <tr>
                                                                <td align="center">
                                                                    @if(is_null($targets_video->video_url))
                                                                    <video width="320" height="320" controls>
                                                                        <source src="{{$targets_video->video_path}}" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                    @elseif(!is_null($targets_video->video_path) && !is_null($targets_video->video_url))
                                                                        <iframe width="320" height="320"
                                                                                src="{{$targets_video->video_url}}">
                                                                        </iframe>
                                                                    @else
                                                                        ERROR
                                                                    @endif
                                                                    <input type="hidden" class="form-control" name="targetVideoId" id="targetVideoId" value="{{ $targets_video->id}}">
                                                                </td>
                                                                @if(auth()->user()->id == $targets->users_id)
                                                                <td  align="center" style="vertical-align: middle;"><button type="button" class="btn btn-danger"  id="videoDelete">刪除</button></td>
                                                                @endif
                                                            </tr>
                                                            </tbody>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color:#009999;color:white">
                                            <b>圖檔來源</b>
                                            @if(auth()->user()->id == $targets->users_id)
                                            <label class="pull-right"><u style="cursor: pointer" data-toggle="modal" data-target="#createTargetImage">[&nbsp;新增圖片&nbsp;]</u></label>
                                            @endif
                                        </div>
                                        <div class="panel-body">
                                            <div class="container-fluid">
                                                <table class="table">
                                                    @if (count($targets_images) === 0)
                                                        <thead>
                                                        <td>還未新增圖片，請開始新增圖片</td>
                                                        </thead>
                                                    @elseif (count($targets_images) >= 1)
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>網址</th>
                                                            @if(auth()->user()->id == $targets->users_id)
                                                            <th>操作</th>
                                                            @endif
                                                        </tr>
                                                        </thead>
                                                        @foreach($targets_images as $targets_image)
                                                            <tbody>
                                                            <tr>
                                                                <td align="center"><div style="width: 120px;height: 120px">{!!Html::image($targets_image->image_path,'',['width'=>'100%','height'=>'100%']) !!}</div></td>
                                                                <td style="vertical-align: middle;">
                                                                    <input type="text" class="form-control" name="url" id="url" value="{{ $targets_image->image_url}}" disabled>
                                                                    <input type="hidden" class="form-control" name="targetImageId" id="targetImageId" value="{{ $targets_image->id}}">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle;">
                                                                    <div class="form-inline">
                                                                        <div class="form-group">
                                                                            <Input type="button" name="imageModifyButton" id="imageModifyButton" class="btn btn-primary imageModifyButton" value="修改">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <Input type="button" class="btn btn-danger" id="imageDelete" value="刪除">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if(!(auth()->guest()))
        @include('vuforia.postTargetVideo')
    @endif

    @if(!(auth()->guest()))
        @include('vuforia.postTargetImage')
    @endif
@endsection

@section('scripts')
    <script>
        $('#imageDelete').click(function (e) {
            bootbox.dialog({
                title: '刪除圖片',
                message:'確認要刪除圖片?',
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
                            $.ajax({
                                url: "/vuforia/imagetargetdelete",
                                type: "POST",
                                data: {imageTargetId: $('#targetImageId').val()},
                                success: function (data) {
                                    location.reload();
                                }
                            });
                        }
                    }
                },
            });
        });

        $('#videoDelete').click(function (e) {
            bootbox.dialog({
                title: '刪除影片',
                message:'確認要刪除影片?',
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
                            $.ajax({
                                url:"/vuforia/videotargetdelete",
                                type:"POST",
                                data:{videoTargetId: $('#targetVideoId').val()},
                                success:function(data){
                                    location.reload();
                                }
                            });
                        }
                    }
                },
            });
        });

        $('.imageModifyButton').click(function (e) {
            var curr = $(this);
            if(curr.parents("td").prev().children('#url').prop('disabled')) {
                curr.parents("td").prev().children('#url').prop('disabled',false);
                curr.val('確定');
            }else{
                $.ajax({
                    url: "/vuforia/imagetargetupdate",
                    type: "POST",
                    data: {url: curr.parents("td").prev().children('#url').val(),imageTargetId: curr.parents("td").prev().children('#targetImageId').val()},
                    success: function (data) {
                        curr.parents("td").prev().children('#url').prop('disabled',true);
                        curr.val('修改');
                    }
                });
            }
        });
    </script>
@endsection