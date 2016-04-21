<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests;
use App\Users_app;
use Illuminate\Http\Request;
use DB;
use PhpParser\Node\Expr\Array_;
use URL;
use Illuminate\Support\Facades\Input;

use HTTP_Request2;
use DateTime;
use DateTimeZone;
use File;
class ApiController extends Controller
{
    private $access_key 	= "42f527449c8c9f45cff6e93bf57cbfb0ccdbf501";
    private $secret_key 	= "c1a818d3997c52d3b5551b97ba6bb40d73c8b604";
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $response =['ClientAccessKey' => 'caa9c811f58e25c93e90906e5bd553c8eb9cd11b', 'ClientSecretKey' => '527ef84f78b418c64589894df6420422333664ee'];
//        return response()->json($response, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function facebookLogout()
    {
        return view('api/logout');
    }

    public function getKey()
    {
//        $response = ['ClientAccessKey' => '30216108febddcc3b868a418750e3c210756210f', 'ClientSecretKey' => '6d949378231058e4961949c90d6954502500b792'];
        $response = ['ClientAccessKey' => '58edd9aaf89accdb6e8ea5fda5373b86f981b375', 'ClientSecretKey' => 'b6be944e8e853e4f4ccc7b279720394ff1b07a95'];
        return response()->json($response, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function addUserApp()
    {
        $input = Input::all();

        $user_app = new Users_app();
        $user_app->name = $input['username'];
        $user_app->email = $input['username'];
        $user_app->password = bcrypt($input['password']);
        $user_app->account_type = $input['account_type'];
        $user_app->active = 1;

        $user_app->save();

        return "true";
    }

    public function addUserFeedback()
    {
        $input = Input::all();

        $feedback = new Feedback();
        $feedback->name = $input['name'];
        $feedback->email = $input['email'];
        $feedback->subject = $input['subject'];
        $feedback->comment = $input['comment'];
        $feedback->rating = $input['rating'];

        $feedback->save();

        return "true";
    }

    public function getContent()
    {
        $imageCollection = collect([]);
        $urlString ='';
        $videoUrl = '';
        $data ='';

        $input = Input::all();

        $targets = DB::table('targets')
            ->where('vuforia_target_id', '=', $input['Vuforid_target_id'])
            ->first();

        $result = $this->getVuforiaTargetStatus($input['Vuforid_target_id']);

        if($result['status'] == 'success') {
            if ($result['total_recos'] < $targets->total_recos) {

                //$this->updateVuforiaTargetStatus($input['Vuforid_target_id'], $targets->image_path);

                $targets_images =   DB::table('targets_images')
                    ->where('targets_id', '=', $targets->id)
                    ->get();

                foreach ($targets_images as $targets_image) {
                    $collection = collect([]);
                    $collection->put('URL', URL::to('/') . $targets_image->image_path);
                    $collection->put('Size', '113999');
                    $urlString .= $targets_image->image_url . ',';
                    $imageCollection->push($collection);
                }
                $data = $imageCollection->toArray();
                $data = json_encode($data, JSON_UNESCAPED_SLASHES);


                $targets_video = DB::table('targets_videos')
                    ->where('targets_id', '=', $targets->id)
                    ->first();

                if (!is_null($targets_video)) {
                    $videoUrl = URL::to('/') . $targets_video->video_path;
                }
            } else {

                $this->updateVuforiaTargetStatus($input['Vuforid_target_id'], 'img/over_scan.png');

//                $collection = collect([]);
//                $collection->put('URL', URL::to('/') . '/img/over_scan.png');
//                $collection->put('Size', '113999');
//                $imageCollection->push($collection);
//
//                $data = $imageCollection->toArray();
//                $data = json_encode($data, JSON_UNESCAPED_SLASHES);
            }
        }

        $response =
            [
                'content_img' => 'empty',
                'x_coordinate' => $targets->x_coordinate,
                'y_coordinate' => $targets->y_coordinate,
                'icon1_url' => 'http://uams.partyzoo.net:8080/uploads/Icons/icon1.png',
                'icon1_x' => '-0.08',
                'icon1_y' => '0',
                'icon2_url' => 'http://uams.partyzoo.net:8080/uploads/Icons/icon2.png',
                'icon2_x' => '0.08',
                'icon2_y' => '0',
                'scale' => '1',
                'link' => $urlString,
                'video' => $videoUrl,
                'video2' => $videoUrl,
                'video_rate' => '',
                'RollImages' => $data,
                'total_recos' => $result['total_recos'],
            ];

        $response = json_encode($response, JSON_UNESCAPED_SLASHES);
        return response($response)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getVuforiaTargetStatus($targetId){

        //$targetId 	= "e18d2b4a4122497d9e98b371b49d98ba";
        $url 		= "https://vws.vuforia.com";
        $requestPath = "/summary/";// . $targetId;

        $requestPath = $requestPath . $targetId;

        $request = new HTTP_Request2();

        $request->setMethod( HTTP_Request2::METHOD_GET );

        $request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $request->setURL( $url . $requestPath );

        $this->setHeaders($request);

        try {
            $response = $request->send();

            if (200 == $response->getStatus()) {
                $result = json_decode($response->getBody());
                $result =  json_decode(json_encode($result), true);
                return $result;
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateVuforiaTargetStatus($targetId,$imageLocation){

        $url 		= "https://vws.vuforia.com";
        $requestPath 	= "/targets/";

        $requestPath = $requestPath . $targetId;

        $jsonBody = json_encode(
            [
                'image'=>$this->getImageAsBase64($imageLocation)
            ]
        );

        $request = new HTTP_Request2();

        $request->setMethod( HTTP_Request2::METHOD_PUT );

        $request->setBody($jsonBody );

        $request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $request->setURL( $url . $requestPath );

        $this->setHeaders($request);

        try {
            $response = $request->send();

            if (200 == $response->getStatus()) {
                $result = json_decode($response->getBody());
                $result =  json_decode(json_encode($result), true);
                return $result;
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function connect()
    {
        $targetId 	= "e18d2b4a4122497d9e98b371b49d98ba";
        $url 		= "https://vws.vuforia.com";

        $requestPath = "/summary/". $targetId;

        $request = new HTTP_Request2();

        $request->setMethod( HTTP_Request2::METHOD_GET );

        $request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $request->setURL( $url . $requestPath );

        $this->setHeaders($request);

        try {

            $response = $request->send();

            if (200 == $response->getStatus()) {
                return $response->getBody();
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }


    }

    private function setHeaders(&$request){

        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT" );
        if($method = $request->getMethod() =='PUT') {
            $request->setHeader("Content-Type", "application/json");
        }
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $this->tmsSignature( $request , $this->secret_key ));
    }

    private function tmsSignature( &$request , $secret_key ){

        $contentType = '';
        $hexDigest = 'd41d8cd98f00b204e9800998ecf8427e'; // Hex digest of an empty string

        $method = $request->getMethod();
        // The HTTP Header fields are used to authenticate the request
        $requestHeaders = $request->getHeaders();
        // note that header names are converted to lower case
        $dateValue = $requestHeaders['date'];

        $requestPath = $request->getURL()->getPath();

        // Not all requests will define a content-type
        if( isset( $requestHeaders['content-type'] ))
            $contentType = $requestHeaders['content-type'];

        if ( $method == 'GET' || $method == 'DELETE' ) {
            // Do nothing because the strings are already set correctly
        } else if ( $method == 'POST' || $method == 'PUT' ) {
            // If this is a POST or PUT the request should have a request body
            $hexDigest = md5( $request->getBody() , false );

        } else {
            print("ERROR: Invalid content type passed to Sig Builder");
        }

        $toDigest = $method . "\n" . $hexDigest . "\n" . $contentType . "\n" . $dateValue . "\n" . $requestPath ;

        //echo $toDigest;

        $shaHashed = "";

        try {
            // the SHA1 hash needs to be transformed from hexidecimal to Base64
            $shaHashed = $this->hexToBase64( hash_hmac("sha1", $toDigest , $secret_key) );

        } catch ( Exception $e) {
            $e->getMessage();
        }

        return $shaHashed;
    }

    private function hexToBase64($hex){

        $return = "";

        foreach(str_split($hex, 2) as $pair){

            $return .= chr(hexdec($pair));

        }

        return base64_encode($return);
    }

    private function getImageAsBase64($imageLocation){
        $file = File::get( $imageLocation );
        if( $file ){
            $file = base64_encode( $file );
        }
        return $file;
    }
}
