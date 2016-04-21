@extends('layouts.app')

@section('title', 'Home')

@section('styles')

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>社群會員</label>
                    <span class="pull-right"><a href="/admin"><b>[&nbsp;返回&nbsp;]</b></a></span>
                </div>
                <div class="panel-body">
                    <table class="table">

                        @if (count($usersApps) === 0)
                            <thead>
                            <td>沒有社群會員登入</td>
                            </thead>
                        @elseif (count($usersApps) >= 1)
                            <thead>
                            <tr>
                                <th>使用者名稱</th>
                                <th>會員帳號</th>
                                <th>登入方式</th>
                                <th>登入次數</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            @foreach($usersApps as $usersApp)
                                <tbody>
                                <tr>
                                    <td>{{$usersApp->name}}</td>
                                    <td>{{$usersApp->email}}</td>
                                    <td>{{$usersApp->account_type}}</td>
                                    <td>{{$usersApp->login_times}}</td>
                                    <td><button type="button" value="{{ $usersApp->id}}" class="btn btn-danger userAppDelete" id="userAppDelete">刪除帳號</button></td>
                                </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>
                    {!! $usersApps->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        $('.userAppDelete').click(function (e) {
            var userAppId = $(this).attr("value");
            bootbox.dialog({
                title: '刪除社群會員帳號',
                message:'確認要刪除社群會員帳號?',
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
                                url: "/vuforia/deletesocialuser",
                                type: "POST",
                                data: {userAppId: userAppId},
                                success: function (data) {
                                    location.reload();
                                }
                            });
                        }
                    }
                },
            });
        });
    </script>
@endsection