<div class="modal fade" id="createTargetImage" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>新增圖片</b></h4>
            </div>
            <div class="modal-body">

                <form id="targetImageForm" action="/vuforia/uploadTargetsImage" onsubmit='postTargetImageSubmit.disabled = true;' method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {!! Form::hidden('created_id', auth()->user()->id) !!}
                    {!! Form::hidden('targets_id', $targets->id) !!}
                    {!! Form::hidden('created_name', auth()->user()->name) !!}

                    <div class="form-group">
                        <div class="post">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">相片上傳</span>
                                <input type="file" class="form-control" name="imageFile" id="imageFile">
                            </div>

                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">網址</span>
                                <input type="text" class="form-control" name="url" id="url">
                            </div>
                            <br/>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit" name="postTargetImageSubmit">上傳</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
