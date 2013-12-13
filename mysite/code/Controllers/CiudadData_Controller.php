<?php

class CiudadData_Controller extends Controller {
    public static $allowed_actions = array(
        'index' => true
    );                       
    
    public static $neighborHoodcouncilEndpoint = "http://controllerdata.lacity.org/resource/f2ec-m4t9.json";

    public function init(){
        parent::init();
    }

    public function Link() {
        return 'cuidad';
    }

    public function index(){
		if(!isset($ch)) $ch = curl_init(); 
		   
		curl_setopt($ch, CURLOPT_URL, self::$neighborHoodcouncilEndpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    	
		$response = curl_exec($ch);
		curl_close($ch);
		
		$NeigborhoodCouncilExpends = Convert::json2array($response);
		
		foreach($NeigborhoodCouncilExpends as $expenditure){  
			$CouncilSystemSet = SystemSet::get('SystemSet')->filter('Name',$expenditure['neighborhood_council'])->first();
			if(!$CouncilSystemSet){
		      $CouncilSystemSet = new SystemSet();
		      $CouncilSystemSet->Name = $expenditure['neighborhood_council'];
		      $SystemID = $CouncilSystemSet->write();
			} else {
				$SystemID = $CouncilSystemSet->ID;
			}
			$Expenditure = new Expenditure();
			$Expenditure->DollarValue = $expenditure['expenditure'];
			$Expenditure->BudgetFiscalYear = $expenditure['bfy'];            
			$Expenditure->Appr = $expenditure['appr'];           
			$Expenditure->Content = "Piensa usted que esta frasa :\"" . $expenditure['description'] . "\" es tan claro?" ;         
			$Expenditure->SystemSetID = $SystemID;
			$Expenditure->write();
			echo "<pre>"; 
				var_dump($expenditure);
			echo "</pre>";
		}
		
    }
   
}