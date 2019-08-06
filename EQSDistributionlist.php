<?php
class EqsDistList
{
	public $id; //String
	public $name; //String
}
class EQSDistributionList
{
	public $eqs_dist_lists; //array(EqsDistList)
}
class EQSDistributionListRequest{
    var $access_token;
	var $resultparam;
    function __construct($access_token){
        $this->access_token = $access_token;
    }
    function get_eqsdistributionList()
    {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://businesscen.crm.dynamics.com/api/data/v8.2/contacts?$select=fullname&$top=30');
        $headers = [
            "Accept: application/json",
            "OData-MaxVersion: 4.0",
            "OData-Version: 4.0",
            "Authorization: Bearer " .$this->access_token
        ];

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		// Will dump a beauty json :3
		$Jsondata = json_decode($result, true);
		if(!isset($Jsondata["value"])){
			echo("Some Error Occured, Data Not Found");
			return;
		}
		$eqsList =  new EQSDistributionList();
		if(sizeof($Jsondata["value"]) > 0){
			for ($x = 0; $x < sizeof($Jsondata["value"] ); $x++) {
				$eqsObj = new EqsDistList();
				$eqsObj->id = $Jsondata["value"][$x]['contactid'];
				$eqsObj->name = $Jsondata["value"][$x]['fullname'];
			  
				$EQSDistributionArr[] =  $eqsObj;
			}
			$eqsList->eqs_dist_lists = $EQSDistributionArr;
			echo("<script>console.log('PHP: ".json_encode($eqsList)."');</script>");
			 return $eqsList;
		} else{
			echo("No Data Found");
			return;
		}
	}
}

?>