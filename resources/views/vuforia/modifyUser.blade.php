<div class="modal fade" id="userModify" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>修改使用者</b></h4>
            </div>
            <div class="modal-body">

                <form id="modifyUserForm" class="form-horizontal" role="form" method="POST" action="{{ url('/vuforia/modifyuser') }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-md-4 control-label">名字</label>

                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="modifyId" id="modifyId">
                            <input type="text" class="form-control" name="modifyName" id="modifyName">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">帳號</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="modifyAccount" id="modifyAccount">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail 地址</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="modifyEmail" id="modifyEmail">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密碼</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="modifyPassword" id="modifyPassword">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">再次輸入密碼</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="modifyPassword_confirmation" id="modifyPassword_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" id="modifyUserSubmitButton">
                                <i class="fa fa-btn fa-user"></i>修改
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
