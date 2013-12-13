<?php

class Civic_Controller extends Controller {
    public static $allowed_actions = array(
        'index' => true
    );                       
    
    public static $googleCivicEndpoint = "https://www.googleapis.com/civicinfo/us_v1/representatives/lookup";
    public static $key = 'AIzaSyDJkm8j9vclu-lN1tU8bx2iCI79_r-2Va0';

    public function init(){
        parent::init();
    }

    public function Link() {
        return 'civic';
    }

    public function index(){
    
      if(!isset($ch)) $ch = curl_init(); 
      
      $CivicSystem = new SystemSet();
      $CivicSystem->Name = 'la cuidad de los angeles';
      $SystemID = $CivicSystem->write();
      
      $json = array('address' => '6200 Hollywood Blvd Los Angeles CA');   
      curl_setopt($ch, CURLOPT_URL, self::$googleCivicEndpoint."?key=".self::$key);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);
      curl_close($ch);
      
      $googleArray = Convert::json2array($response);
      
      $officeCodes = array();
      
	  foreach($googleArray["offices"] as  $office){
        $OptionsGroup = new OptionsGroup();
        $OptionsGroup->Name = $office['name'];       
        $OptionsGroup->Source = self::$googleCivicEndpoint;
        $OptionsGroup->OfficialIds = $office['officialIds'][0];
        $OptionsGroup->SystemSetID = $CivicSystem->ID;
        $OptionsGroup->write(); 
        $officeCodes[] = $office['officialIds'][0]; 
      }                      
      
	  foreach($officeCodes as $office){       
	  	$Decision = new Decision();
	  	$Decision->Content = "Elected official " . $googleArray['officials'][$office]["name"] . " is sufficiently engaged on social media."; 
        $Decision->SystemSetID = $CivicSystem->ID;     
        $Decision->write();
		if(isset($googleArray['officials'][$office]["channels"])){ 
	        foreach($googleArray['officials'][$office]["channels"] as $mediaChannel){
			    $DecidingFactor = new DecidingFactor();
			  	$DecidingFactor->Content = "Media Channel: " . $mediaChannel["type"] . " handle: " . $mediaChannel["id"]; 
		        $DecidingFactor->DecisionID = $Decision->ID;     
		        $DecidingFactor->write();
			}
		}
		      
      }
      
    }
   

}