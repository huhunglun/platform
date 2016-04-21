@extends('layouts.app')

@section('styles')
    {!! Html::style('css/star-rating.min.css') !!}
<style>
    .word-wrap {
        word-wrap: break-word;
        max-width:150px;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>回饋信息</label>
                    <span class="pull-right"><a href="/admin"><b>[&nbsp;返回&nbsp;]</b></a></span>
                </div>
                <div class="panel-body">
                    <table class="table">
                        @if (count($feedbacks) === 0)
                            <thead>
                            <td>沒有回饋信息</td>
                            </thead>
                        @elseif (count($feedbacks) >= 1)
                            <thead>
                            <tr>
                                <th>回饋者名稱</th>
                                <th>Email</th>
                                <th>回饋主旨</th>
                                <th>回饋信息</th>
                                <th>星星</th>
                                <th>回復內容</th>
                                <th>回復狀態</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($feedbacks as $feedback)
                                <tbody>
                                    <tr>
                                        <td>{{$feedback->name}}</td>
                                        <td>{{$feedback->email}}</td>
                                        <td>{{$feedback->subject}}</td>
                                        <td class="word-wrap">{{$feedback->comment}}</td>
                                        <td style="width:200px"><input id="rate" name="rating" class="rating" readonly="true" data-show-caption="false" data-show-clear="false" data-min="0" data-max="5" data-size="xs" value="{{$feedback->rating}}"></td>
                                        <td class="word-wrap">{{$feedback->content_response}}</td>
                                        @if($feedback->response == 0)
                                            <td>未回覆</td>
                                        @else
                                            <td>己回覆</td>
                                        @endif
                                        <td><a data-toggle="modal" data-target="#feedbackEmail" id="{{$feedback->id}}" name="{{$feedback->name}}" email="{{$feedback->email}}" class="btn btn-success sendFeedbackEmail" id="sendFeedbackEmail">傳送Email</a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>
                    {!! $feedbacks->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>

@include('vuforia.sendFeedbackEmail')

@endsection

@section('scripts')
    {!! Html::script('js/star-rating.min.js') !!}
    <script>
        $('.sendFeedbackEmail').click(function () {
            $("#id").val($(this).attr("id"));
            $("#receiver").val($(this).attr("email"));
            $("#receiverName").val($(this).attr("name"));
        });
    </script>
@endsection