<?php
/**
 * Created by PhpStorm.
 * User: mhamdi
 * Date: 22/10/18
 * Time: 17:18
 */
error_reporting( E_ALL );

$merchant_identifier = 'pslMUZQZ';
$sha_request_phrase  = 'BTFRCGHCV';
$access_code         = 'LSl2S48hXGvUWTJq8vFd';
$payfortURL          = 'https://sbcheckout.PayFort.com/FortAPI/paymentPage'; //'https://checkout.payfort.com/FortAPI/paymentPage';
$token_name          = str_random( 8 );
$returnURL           = "http://localhost/payfort/payfort2.php";
//$customer_ip = $_SERVER['REMOTE_ADDR'];

$requestParams = array(
	'access_code'         => $access_code, //'mGwuytxwMBE4lJCIlnl5' ,
	//'amount' => '1000',
	//'command' => 'PURCHASE',
	//'currency' => 'EGP',
	//'customer_email' => 'test@payfort.com',
	//'customer_ip'=>$customer_ip,
	'language'            => 'en',
	'merchant_identifier' => $merchant_identifier, //'dAQlHKed',
	'merchant_reference'  => '101', //.'-'.$item->id,
	'return_url'          => $returnURL,//'http://localhost/viva/payment/merchant-page',
	'service_command'     => 'TOKENIZATION',
	'token_name'          => $token_name,
	//'order_description' => 'Item',
	//'signature' => 'a9b02b3ebb8355d4444695a4c3f6be83d11328c9a2001fa528ab7210dc443333',
);


//// Information that will be provided from user
/// Card Info from the form submitted before
$userData = [
	'expiry_date' => $_POST['expire_year'].$_POST['expire_month'],  //'2105',
	'card_number' => $_POST['card_number'],//'4005550000000001',
	'card_security_code' => $_POST['card_security_code'], //'123',
	'card_holder_name' => $_POST['card_holder_name'], //'Mahmoud Hamdi',
	'remember_me' => 'NO'];

//046	Channel is not configured for the selected payment option.

$signText = $sha_request_phrase;
foreach ( $requestParams as $k => $val ) {
	$signText .= $k . '=' . $val;
}
$signText  .= $sha_request_phrase;
$signature = hash( 'sha256', $signText, false );
?>

<html>
<head>
<title>Test Payfort</title>
</head>
<body>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="col-md-12" style="margin-bottom: 20px;">
            <h4>You are going to pay $1.0 for Donation</h4>
        </div>
        <form method="post" action="<?php echo $payfortURL ?>">
			<?php

			foreach ( $requestParams as $a => $b ) {
				echo "\t<input type='hidden' name='" . htmlentities( $a ) . "' value='" . htmlentities( $b ) . "'>\n";
			}
			echo "\t<input type='hidden' name='signature' value='" . htmlentities( $signature ) . "'>\n";

			foreach ( $userData as $a => $b ) {
				echo "\t<input type='hidden' name='" . htmlentities( $a ) . "' value='" . htmlentities( $b ) . "'>\n";
			}

			?>

            <button class="btn btn-primary pull-right" type="submit">
                Pay
            </button>
        </form>
    </div>
</div>
</body>
</html>

<?php
function str_random($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
?>
