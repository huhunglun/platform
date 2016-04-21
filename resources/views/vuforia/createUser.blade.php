<div class="modal fade" id="createUser" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>新增使用者</b></h4>
            </div>
            <div class="modal-body">

                <form id="createUserForm" class="form-horizontal" role="form" method="POST" action="{{ url('/vuforia/createuser') }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-md-4 control-label">名字</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">帳號</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="account" id="account">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail 地址</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密碼</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">再次輸入密碼</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" id="userSubmitButton">
                                <i class="fa fa-btn fa-user"></i>註冊
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
