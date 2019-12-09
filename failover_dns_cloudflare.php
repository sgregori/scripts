<?php

$dominio = 'domain_to_update';

$server_1 = 'http://xxxxxx/';
$ip[$server_1]='xxx.xxx.xxx.xxx';

$server_2 = 'http://xxxxxx/';
$ip[$server_2]='xxx.xxx.xxx.xxx';


function check($url){

	$output = @file_get_contents($url);

	if ( strpos( $output, 'XXXXX_SEARCH_STRING_XXXXXX' ) ) {
		return true;
	} else {
		return false;
	}

}

function update_dns($server){

	global $dominio;

	if( gethostbyname( $dominio ) == $server ){

		echo "Not needed to update DNS\n\n\n";

	} else {

		echo "Updating DNS...\n\n\n";

		$apikey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx'; // Cloudflare Global API
		$email = 'xxxxxxxxxxxxxxxxxxxxxxxxx'; // Cloudflare Email Adress
		$domain = 'xxxxxxxxxxxxxxxxxxxxxxxxx';  // zone_name // Cloudflare Domain Name
		$zoneid = 'xxxxxxxxxxxxxx'; // zone_id // Cloudflare Domain Zone ID

	   	$ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records/XXXXXXXXXXXXXXXXXXXX");
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'X-Auth-Email: '.$email.'', 'X-Auth-Key: '.$apikey.'', 'Cache-Control: no-cache', // 'Content-Type: multipart/form-data; charset=utf-8',
     	        'Content-Type:application/json','purge_everything: true' ));

    		$data = array(
    			'type' => 'A',
    			'name' => 'check',
    			'content' => ''.$server.'',
    			'zone_name' => ''.$domain.'',
    			'zone_id' => ''.$zoneid.'',
    			'proxiable' => 'true',
    			'proxied' => false,
    			'ttl' => 120
    		);

    		$data_string = json_encode($data);

    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

    		$sonuc = curl_exec($ch);
    		return $sonuc;
    		curl_close($ch);

	}

}

if( check($server_1) ){

	echo "Server1 WORKING\n\n";

        var_export( update_dns($ip[$server_1]) );


} else {

	echo "Server1 DOWN\n";

	if( check($server_2) ){

		echo "Server2 WORKING\n\n";
		var_export( update_dns($ip[$server_2]) );

	} else {

		echo "Server 2 DOWN\n\n";

	}

}


?>
