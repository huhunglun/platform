<div class="modal fade" id="feedbackEmail" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>傳送回饋信息</b></h4>
            </div>
            <div class="modal-body">
                <form id="sendFeedbackForm" action="/sendfeedbackemail" onsubmit='postTargetImageSubmit.disabled = true;' method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <div class="post">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">收件人</span>
                                <input type="text" class="form-control" name="receiver" id="receiver" readonly>
                            </div>

                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">收件人名稱</span>
                                <input type="text" class="form-control" name="receiverName" id="receiverName" readonly>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">主題</span>
                                <input type="text" class="form-control" name="subject" id="subject">
                            </div>

                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">內容</span>
                                <textarea style="resize:none" class="form-control" name="content" id="content"></textarea>
                            </div>
                            <br/>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">傳送Email</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
