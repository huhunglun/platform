<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

{!! Html::script('js/alert.js') !!}
{!! Html::script('js/jquery.validate.min.js') !!}
{!! Html::script('js/validation_rules.js') !!}
{!! Html::script('js/bootbox.js') !!}
{!! Html::script('js/script.js') !!}
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>

<script>

    function checkFileExtension(elem){
        var filePath = elem;

        if (filePath.indexOf('.') == -1) {
            remove(elem);
            $.alert("不正確的副檔名格式");
            return false;
        }
        var validExtensions = new Array('jpg','png');
        var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

        for (var i = 0; i < validExtensions.length; i++) {
            if (ext == validExtensions[i])
            {
                return true;
            }
        }
        $.alert("不正確的副檔名格式： " + ext.toUpperCase());
        return false;
    }
    $(document).ready(function (){

        $('#file').change(function(){
            if(checkFileExtension($('#file').val())){
                $('#formImage').trigger('submit');
            }
        });

        $("#formImage").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
                url: "/vuforia/uploadImage",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    console.log("SUCCESS");
                    $("#preview").attr("src",data);
                    $("#imageLocation").val(data);
                    $('label[for=imageLocation]').remove();
                },
                error: function(data){
                    console.log("ERROR");
                }
            });
        }));
    });
</script>

{{--{!! Html::script('js/bootstrap-datepicker.min.js') !!}--}}

{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--//Datepicker--}}
        {{--$('#date-container .input-group.date').datepicker({--}}
            {{--todayBtn: "linked",--}}
            {{--todayHighlight: true,--}}
            {{--toggleActive: true--}}

        {{--});--}}
    {{--});--}}
{{--</script>--}}

@yield('scripts')