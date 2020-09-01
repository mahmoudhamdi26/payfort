<?php
/**
 * Created by PhpStorm.
 * User: mhamdi
 * Date: 22/10/18
 * Time: 17:19
 */

$customer_ip = $_SERVER['REMOTE_ADDR'];
$returnURL = 'http://localhost/payfort/payfort3.php';
$merchant_identifier = 'pslMUZQZ';
$sha_request_phrase = 'BTFRCGHCV'; //'BTFRCghc7v';
$access_code = 'LSl2S48hXGvUWTJq8vFd';
$payfortURL = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi'; //'https://paymentservices.payfort.com/FortAPI/paymentApi';
// //'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';

$requestParams = array(
	'access_code' => $access_code, //'mGwuytxwMBE4lJCIlnl5' ,
	'amount' => round(10.25, 0), //'1000',
	'command' => 'PURCHASE',
	'currency' => 'EGP',
	'customer_email' => 'mahmoud.h26@gmail.com',
	'customer_ip'=>$customer_ip,
	'language' => 'en',
	'merchant_identifier' => $merchant_identifier,//'dAQlHKed',
	'merchant_reference' => '101',
	'return_url'=> $returnURL, //'http://localhost/viva/payment/payfort-response',
//            'service_command'=>'TOKENIZATION',
	'token_name'=> $_GET['token_name'], //'gftbbvfdt'
	//'order_description' => 'Item',
	//'signature' => 'a9b02b3ebb8355d4444695a4c3f6be83d11328c9a2001fa528ab7210dc443333',
);

$signText = $sha_request_phrase; //'TESTSHAIN';
foreach($requestParams as $k=>$val){
	$signText.=$k.'='.$val;
}
$signText.=$sha_request_phrase; //'TESTSHAIN';

$signature = hash('sha256', $signText, false);
$requestParams['signature'] = $signature;
$redirectUrl = $payfortURL;

// Setup cURL
$ch = curl_init($redirectUrl);
curl_setopt_array($ch, array(
	CURLOPT_POST => TRUE,
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_HTTPHEADER => array(
		//'Authorization: '.$authToken,
		'Content-Type: application/json'
	),
	CURLOPT_POSTFIELDS => json_encode($requestParams)
));

// Send the request
$response = curl_exec($ch);

// Check for errors
if($response === FALSE){
	die(curl_error($ch));
}

// Decode the response
$responseData = json_decode($response, TRUE);
//print_r($responseData);
if(key_exists("3ds_url", $responseData)){
	echo 'redirect to <a href="'.$responseData["3ds_url"].'">'.$responseData["3ds_url"].'</a>';
}

print_r($response);
