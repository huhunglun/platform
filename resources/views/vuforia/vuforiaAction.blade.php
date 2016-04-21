<?php

include(app_path().'/Included/UpdateTarget.php');
include(app_path().'/Included/DeleteTarget.php');
include(app_path().'/Included/PostNewTarget.php');

$instance = null;

if( isset($selected) ){

    $success = false;
    switch( $selected ){

        case "UpdateTarget" :
            $instance = new UpdateTarget($targetId,$vuforiaName,800,$imageLocation,"");
            $result = json_decode($instance->result);
            $result =  json_decode(json_encode($result), true);
            if($result['result_code']=="Success"){
                $success =true;
                $action ="/vuforia/updatetarget";
            }
            break;
        case "DeleteTarget" :
            $instance = new DeleteTarget($targetId);
            $result = json_decode($instance->result);
            $result =  json_decode(json_encode($result), true);
            if($result['result_code']=="Success"){
                $success =true;
                $action ="/vuforia/targetdelete";
            }
            break;
        case "PostTarget" :
            $instance = new PostNewTarget($vuforiaName,800,$imageLocation,"");
            $result = json_decode($instance->result);
            $result =  json_decode(json_encode($result), true);
            if($result['result_code']=="TargetCreated"){
                $success =true;
                $targetId =$result['target_id'];
                $action ="/vuforia/storetarget";
            }
            break;
        default :
            echo "INVALID SELECTION";
            break;
    }
}
    if($success){
?>
<form id="formData" action="{{$action}}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if($selected == "DeleteTarget")
        <input type="hidden" name="id" value="{{$id}}">
    @else
        <input type="hidden" name="userId" value="{{$userId}}">
        <input type="hidden" name="targetId" value="{{$targetId}}">
        <input type="hidden" name="name" value="{{$name}}">
        <input type="hidden" name="vuforiaName" value="{{$vuforiaName}}">
        @if($selected == "UpdateTarget")
            <input type="hidden" name="x_coordinate" value="{{$x_coordinate}}">
            <input type="hidden" name="y_coordinate" value="{{$y_coordinate}}">
            <input type="hidden" name="total_recos" value="{{$total_recos}}">
        @elseif($selected == "PostTarget")
            <input type="hidden" name="imageLocation" value="{{$imageLocation}}">
        @endif
    @endif
</form>
<?php
    }
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup(
                {
                    headers:
                    {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    }
                });

        if("{{$success}}"){
            $('#formData').trigger('submit');
        }
    });
</script>