@extends('layouts.app')

@section('content')

@can('isSuperAdmin',auth()->user())
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>最高管理者</b>
                </div>
                <div class="panel-body">
                    <table class="table">
                        @if (count($superAdmins) === 0)
                            <thead>
                            <td>還未有會員</td>
                            </thead>
                        @elseif (count($superAdmins) >= 1)
                            <thead>
                            <tr>
                                <th>使用者名稱</th>
                                <th>會員登入帳號</th>
                                <th>會員帳號</th>
                                <th>辨識圖數量</th>
                                <th>建立日期</th>
                                <th>啟用狀態</th>
                                <th>總共已辨識次數</th>
                                <th>總共可辨識次數</th>
                                @can('isSuperAdmin',auth()->user())
                                <th>權限</th>
                                @endcan
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($superAdmins as $superAdmin)
                                <tbody>
                                <tr>
                                    <td><a href="/getusertarget/{{$superAdmin->id}}">{{$superAdmin->name}}</a></td>
                                    <td>{{$superAdmin->email}}</td>
                                    <td>{{$superAdmin->account}}</td>
                                    <td>{{$superAdmin->total_count}}</td>
                                    <td>{{$superAdmin->created_at}}</td>
                                        <td><a style="cursor:pointer" class="status" value="{{ $superAdmin->id}}" status="0">
                                                @if($superAdmin->active == 1)
                                                    <label>啟用中</label>
                                                @elseif($superAdmin->active == 0)
                                                    <label>關閉中</label>
                                                @else
                                                    <label>ERROR</label>
                                                @endif
                                            </a>
                                        </td>
                                    <td>{{$recoSum}}</td>
                                    <td>{{$totalRecoSum}}</td>
                                    @can('isSuperAdmin',auth()->user())
                                        <td><b>{{$superAdmin->role_name}}</b></td>
                                    @endcan
                                        <td><a href="" id="{{ $superAdmin->id}}" name="{{$superAdmin->name}}" email="{{$superAdmin->email}}" account="{{$superAdmin->account}}" class="btn btn-success userModify" id="userModify" data-toggle="modal" data-target="#userModify">修改</a></td>
                                        <td><button type="button" value="{{ $superAdmin->id}}" class="btn btn-danger userDelete" id="userDelete">刪除帳號</button></td>
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
@endcan

@can('isSuperAdmin',auth()->user())
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>經銷商 / 管理員</b>
                    @can('isSuperAdmin',auth()->user())
                    <span class="pull-right"><a href="" data-toggle="modal" data-target="#createAdmin"><b>[&nbsp;新增經銷商 / 管理員&nbsp;]</b></a></span>
                    @endcan
                </div>
                <div class="panel-body">
                    <table class="table">
                        @if (count($admins) === 0)
                            <thead>
                            <td>還未有會員</td>
                            </thead>
                        @elseif (count($admins) >= 1)
                            <thead>
                            <tr>
                                <th>使用者名稱</th>
                                <th>會員登入帳號</th>
                                <th>會員帳號</th>
                                <th>辨識圖數量</th>
                                <th>建立日期</th>
                                <th>啟用狀態</th>
                                @can('isSuperAdmin',auth()->user())
                                <th>權限</th>
                                @endcan
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($admins as $admin)
                                <tbody>
                                <tr>
                                    <td><a href="/getusertarget/{{$admin->id}}">{{$admin->name}}</a></td>
                                    <td>{{$admin->email}}</td>
                                    <td>{{$admin->account}}</td>
                                    <td>{{$admin->total_count}}</td>
                                    <td>{{$admin->created_at}}</td>
                                    <td><a style="cursor:pointer" class="status" value="{{ $admin->id}}" status="0">
                                            @if($admin->active == 1)
                                                <label>啟用中</label>
                                            @elseif($admin->active == 0)
                                                <label>關閉中</label>
                                            @else
                                                <label>ERROR</label>
                                            @endif
                                        </a>
                                    </td>
                                    @can('isSuperAdmin',auth()->user())
                                    <td><b>{{$admin->role_name}}</b></td>
                                    @endcan
                                    @if(auth()->user()->id != $admin->id)
                                        <td><a href="" id="{{ $admin->id}}" name="{{$admin->name}}" email="{{$admin->email}}" account="{{$admin->account}}" class="btn btn-success userModify" id="userModify" data-toggle="modal" data-target="#userModify">修改</a></td>
                                        <td><button type="button" value="{{ $admin->id}}" class="btn btn-danger userDelete" id="userDelete">刪除帳號</button></td>
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
@endcan

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>自營商 / 客戶</b>
                    <span class="pull-right"><a href="" data-toggle="modal" data-target="#createUser"><b>[&nbsp;新增自營商 / 客戶&nbsp;]</b></a></span>
                </div>
                <div class="panel-body">
                    <table class="table">
                        @if (count($users) === 0)
                            <thead>
                            <td>還未有會員</td>
                            </thead>
                        @elseif (count($users) >= 1)
                            <thead>
                            <tr>
                                <th>使用者名稱</th>
                                <th>會員登入帳號</th>
                                <th>會員帳號</th>
                                <th>辨識圖數量</th>
                                <th>建立日期</th>
                                <th>啟用狀態</th>
                                @can('isSuperAdmin',auth()->user())
                                <th>權限</th>
                                @endcan
                                <th>操作</th>
                            </tr>
                            </thead>
                            @foreach($users as $user)
                                <tbody>
                                <tr>
                                    <td><a href="/getusertarget/{{$user->id}}">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->account}}</td>
                                    <td>{{$user->total_count}}</td>
                                    <td>{{$user->created_at}}</td>
                                    @if($user->active == 1)
                                        <td><a style="cursor:pointer" class="status" value="{{ $user->id}}" status="0"><label style="cursor:pointer">啟用中</label></a></td>
                                    @elseif($user->active == 0)
                                        <td><a style="cursor:pointer" class="status" value="{{ $user->id}}" status="1"><label style="cursor:pointer">關閉中</label></a></td>
                                    @else
                                        <label>ERROR</label>
                                    @endif
                                    @can('isSuperAdmin',auth()->user())
                                    <td><b>{{$user->role_name}}</b></td>
                                    @endcan
                                    @if(auth()->user()->id != $user->id)
                                        <td><a href="" id="{{ $user->id}}" name="{{$user->name}}" email="{{$user->email}}" account="{{$user->account}}" class="btn btn-success userModify" id="userModify" data-toggle="modal" data-target="#userModify">修改</a></td>
                                        <td><button type="button" value="{{ $user->id}}" class="btn btn-danger userDelete" id="userDelete">刪除帳號</button></td>
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

@can('isSuperAdmin',auth()->user())
@include('vuforia.createAdmin')
@include('vuforia.createUser')
@endcan

@can('isAdmin',auth()->user())
@include('vuforia.createUser')
@endcan

@include('vuforia.modifyUser')

@endsection
@section('scripts')
    <script>
        $('.status').click(function (e) {
            var userId = $(this).attr("value");
            var status = $(this).attr("status");
            bootbox.dialog({
                title: '更改啟用狀態',
                message:'確認要更改啟用狀態?',
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
                                url: "/vuforia/updatestatus",
                                type: "POST",
                                data: {userId: userId, status: status},
                                success: function (data) {
                                    location.reload();
                                }
                            });
                        }
                    }
                },
            });
        });

        $('.userDelete').click(function (e) {
            var userId = $(this).attr("value");
            bootbox.dialog({
                title: '刪除使用者帳號',
                message:'確認要刪除使用者帳號?',
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
                                url: "/vuforia/userdelete",
                                type: "POST",
                                data: {userId: userId},
                                success: function (data) {
                                    location.reload();
                                }
                            });
                        }
                    }
                },
            });
        });

        $('.userModify').click(function () {
            $("#modifyId").val($(this).attr("id"));
            $("#modifyName").val($(this).attr("name"));
            $("#modifyAccount").val($(this).attr("account"));
            $("#modifyEmail").val($(this).attr("email"));
        });


    </script>
@endsection