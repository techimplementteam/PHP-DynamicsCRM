<?php
class Token{
    private $access_token;

    private $client_secret;
    private $client_id;
    private $username;
    private $password;
    private $org_url;
    public function __construct($client_secret, $client_id, $username, $password, $org_url){
        $this->client_secret = urlencode($client_secret);
        $this->client_id = $client_id;
        $this->username = $username;
        $this->password = $password;
        $this->org_url = $org_url;
    }

    public function send_token_request()
    {
        $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://login.microsoftonline.com/common/oauth2/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "client_id={$this->client_id}&resource={$this->org_url}&grant_type=password&username={$this->username}&password={$this->password}&client_secret={$this->client_secret}",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		  exit();
		} else {
			$obj = json_decode($response);
			$this->access_token = $obj->access_token;
		}
    }

    function get_access_token()
    {
        return $this->access_token;
    }
}
?>