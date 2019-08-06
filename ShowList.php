<html>
<head>
    <title>Blank Web Page</title>
</head>
	<body>
	<?php
		require 'Token.php';
		require 'EQSDistributionlist.php';
		ob_start();
		$token = new Token(<client_secret>,<client_id>,<username>,<password>,<organization_url>);
		$token->send_token_request();

		$eqsdistributionlist = new EQSDistributionListRequest($token->get_access_token());
		$eqsdistributionlists = $eqsdistributionlist->get_eqsdistributionList();
		?>
		<table  border="1">
		 <tr>
    <th colspan="4">List ID</th>
    <th colspan="3">List Name</th>
  </tr>
		<?php
		if($eqsdistributionlists != null){ 
	     for ($x = 0; $x < sizeof($eqsdistributionlists->eqs_dist_lists); $x++) {
			 ?>
			<tr>
			<td colspan="4">
			<?php print_r($eqsdistributionlists->eqs_dist_lists[$x]->id);?>
			</td>
			<td colspan="3">
			<?php print_r($eqsdistributionlists->eqs_dist_lists[$x]->name);?>
			</td>
			</tr>
			<?php
		 }
		}else{
			
		}
	?>
</table>
</body>
</html>


