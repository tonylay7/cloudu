<?php

$curl = curl_init();
$URL = "https://zenquotes.io/api/random";
curl_setopt($curl, CURLOPT_URL, $URL);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($curl);
$err = curl_error($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
//	echo $response;
}

$response = json_decode($response, true);

echo ($response);

?>