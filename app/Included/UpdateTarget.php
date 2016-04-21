<?php

require_once 'HTTP/Request2.php';
require_once 'SignatureBuilder.php';

// See the Vuforia Web Services Developer API Specification - https://developer.vuforia.com/resources/dev-guide/retrieving-target-cloud-database
// The UpdateTarget sample demonstrates how to update the attributes of a target using a JSON request body. This example updates the target's metadata.

class UpdateTarget{

	//Server Keys
	private $access_key 	= "42f527449c8c9f45cff6e93bf57cbfb0ccdbf501";
	private $secret_key 	= "c1a818d3997c52d3b5551b97ba6bb40d73c8b604";

	private $targetId;
	private $url 			= "https://vws.vuforia.com";
	private $requestPath 	= "/targets/";
	private $request;
	private $jsonBody 		= "";
	private $imageLocation;
	public $result;
	
	function UpdateTarget($targetId,$targetName,$targetWidth,$targetImageLocation,$targetMetadata){
		$this->targetId =$targetId;
		$this->name =$targetName;
		$this->width =$targetWidth;
		$this->imageLocation = $targetImageLocation;
		$this->application_metadata =$targetMetadata;

		$this->requestPath = $this->requestPath . $this->targetId;
		
		$helloBase64 = base64_encode($this->application_metadata);
		if($this->imageLocation !=""){
			$this->jsonBody = json_encode(
					[
							'image' =>$this->getImageAsBase64(),
							'application_metadata' => $helloBase64,
							'name'=>$this->name,
							'width'=>$this->width
					]
			);
		}else{
			$this->jsonBody = json_encode(
					[
							'application_metadata' => $helloBase64,
							'name'=>$this->name,
							'width'=>$this->width
					]
			);
		}

		$this->result = $this->execUpdateTarget();
		return $this->result ;
	}

	public function execUpdateTarget(){

		$this->request = new HTTP_Request2();
		$this->request->setMethod( HTTP_Request2::METHOD_PUT );
		$this->request->setBody( $this->jsonBody );

		$this->request->setConfig(array(
				'ssl_verify_peer' => false
		));

		$this->request->setURL( $this->url . $this->requestPath );

		// Define the Date and Authentication headers
		$this->setHeaders();


		try {

			$response = $this->request->send();

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

	private function setHeaders(){
		$sb = 	new SignatureBuilder();
		$date = new DateTime("now", new DateTimeZone("GMT"));

		// Define the Date field using the proper GMT format
		$this->request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT" );
		$this->request->setHeader("Content-Type", "application/json" );
		// Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
		$this->request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $sb->tmsSignature( $this->request , $this->secret_key ));

	}
	
	function getImageAsBase64(){
		
		$file = file_get_contents( $this->imageLocation );
		
		if( $file ){
			
			$file = base64_encode( $file );
		}
		
		return $file;
	}
	
}

?>
