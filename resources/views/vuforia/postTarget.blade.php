<div class="modal fade" id="createTarget" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>新增廣告</b></h4>
            </div>
            <div class="modal-body">

                <form id="formImage" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <div class="post">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">相片上傳</span>
                                <input type="file" class="form-control" name="file" id="file">
                            </div>
                        </div>
                    </div>
                </form>

                <form action="/vuforia/vuforiaAction" id="form" onsubmit='postTargetSubmit.disabled = true;' method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {!! Form::hidden('created_id', auth()->user()->id) !!}
                        {!! Form::hidden('created_name', auth()->user()->name) !!}

                    <div class="input-group">
                        <span class="input-group-addon">名稱</span>
                        <input type="text" class="form-control" name="name" id="name">
                        <input type="hidden" class="form-control" name="select" id="select" value="PostTarget">
                    </div>
                    <br/>

                    <div class="input-group">
                        <input type="hidden" class="form-control" name="imageLocation" id="imageLocation">
                    </div>
                    <br/>

                    <div id="targetLayer">
                        <img id="preview" name=preview" style="width:220px;height:180px;margin-left:auto;margin-right:auto;display:block;" src="/img/default.png">
                    </div>
                    <br/>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" name="postTargetSubmit">新增</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
