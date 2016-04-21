<div class="modal fade" id="createTargetVideo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>新增影片</b></h4>
            </div>
            <div class="modal-body">
                <div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#video" aria-controls="video" role="tab" data-toggle="tab">MP4或MP3</a></li>
                        <li role="presentation"><a href="#youtube" aria-controls="youtube" role="tab" data-toggle="tab">Youtube網址</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="video">
                            <br/>
                            <form id="targetVideoForm" action="/vuforia/uploadTargetsVideo" onsubmit='videoSubmit.disabled = true;' method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {!! Form::hidden('created_id', auth()->user()->id) !!}
                                {!! Form::hidden('targets_id', $targets->id) !!}
                                {!! Form::hidden('created_name', auth()->user()->name) !!}
                                <div class="form-group">
                                    <div class="post">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">影片上傳</span>
                                            <input type="file" class="form-control" name="video" id="video">
                                        </div>
                                        <br/>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit" name="videoSubmit">上傳</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="youtube">
                            <br/>
                            <form id="targetYoutubeForm" action="/vuforia/uploadtargetsyoutube" onsubmit='youtubeSubmit.disabled = true;' method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {!! Form::hidden('created_id', auth()->user()->id) !!}
                                {!! Form::hidden('targets_id', $targets->id) !!}
                                {!! Form::hidden('created_name', auth()->user()->name) !!}
                                <div class="form-group">
                                    <div class="post">
                                        <div class="input-group">
                                            <span class="input-group-addon">YouTube網址</span>
                                            <input type="text" class="form-control" name="youtubeUrl" id="youtubeUrl">
                                        </div>
                                        <br/>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit" id="youtubeSubmit" name="youtubeSubmit">上傳</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
