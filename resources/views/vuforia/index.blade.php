@extends('layouts.app')

@section('content')

    <?php

    include(app_path().'/Included/GetTarget.php');
    include(app_path().'/Included/UpdateTarget.php');
    include(app_path().'/Included/DeleteTarget.php');
    include(app_path().'/Included/PostNewTarget.php');
    include(app_path().'/Included/GetAllTargets.php');

    $instance = null;
    if( isset( $_GET['select']) ){

        $selection = $_GET['select'];

        echo "<div> $selection RESULT :</div><br/>";

        echo "<div class='result'>";

        switch( $selection ){

            case "GetTarget" :
                $instance = new GetTarget();
                $result = json_decode($instance->result);
                $result =  json_decode(json_encode($result), true);
                var_dump($result);
                break;
                break;
            case "UpdateTarget" :
                $instance = new UpdateTarget();
                break;
            case "DeleteTarget" :
                $instance = new DeleteTarget();
                break;
            case "PostNewTarget" :
                $instance = new PostNewTarget();
                break;
            case "GetAllTargets" :
                $instance = new GetAllTargets();

                break;
            default :
                echo "INVALID SELECTION";
                break;
        }
        echo "</div>";
        echo "<br /><div>~~~~~~~~~~~~~~~</div><br />";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Vuforia</div>
                    <div class="panel-body">
                        <div>Samples:</div>
                        <br />
                        <div>
                            <a href="vuforia?select=GetTarget"><b>GetTarget.php</b> queries a single target by target id.</a>
                        </div>
                        <br />
                        <div>
                            <a href="vuforia?select=GetAllTargets"><b>GetAllTargets.php</b> queries for all target ids in a Cloud Reco database.</a>
                        </div>
                        <br />
                        <div>
                            <a href="vuforia?select=UpdateTarget"><b>UpdateTarget.php</b> updates the metadata for a target.</a>
                        </div>
                        <br />
                        <div>
                            <a href="vuforia?select=DeleteTarget"><b>DeleteTarget.php</b> deletes a target from its Cloud Database.</a>
                        </div>
                        <br />
                        <div>
                            <a href="vuforia?select=PostNewTarget"><b>PostNewTarget.php</b> uploads a new target to a Cloud Database.</a>
                        </div>
                        <br />
                        <br />
                        <br />
                        <br />
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
