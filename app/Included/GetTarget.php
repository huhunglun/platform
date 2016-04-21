<?php

require_once 'HTTP/Request2.php';
require_once 'SignatureBuilder.php';

// See the Vuforia Web Services Developer API Specification - https://developer.vuforia.com/resources/dev-guide/retrieving-target-cloud-database
// The GetTarget sample demonstrates how to query a single target by target id.
class GetTarget{
	
	//Server Keys
	private $access_key 	= "42f527449c8c9f45cff6e93bf57cbfb0ccdbf501";
	private $secret_key 	= "c1a818d3997c52d3b5551b97ba6bb40d73c8b604";
	
	private $targetId 	= "e811efbed3684d34a872a1efbf59b5d3";
	private $url 		= "https://vws.vuforia.com";
//	private $requestPath = "/targets/";// . $targetId;
	private $requestPath = "/summary/";// . $targetId;
	private $request;
	public $result;
	
	function GetTarget($id){

		$this->targetId = $id;
		$this->requestPath = $this->requestPath . $this->targetId;

		$this->result = $this->execGetTarget();
	}
	
	private function execGetTarget(){
		
		$this->request = new HTTP_Request2();
		$this->request->setMethod( HTTP_Request2::METHOD_GET );
		
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
		// Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
		$this->request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $sb->tmsSignature( $this->request , $this->secret_key ));

	}
}

?>