<?php
/**
 * Created by PhpStorm.
 * User: mhamdi
 * Date: 30/10/18
 * Time: 14:36
 */
?>

<html>
<head>
	<title>Card Form</title>
</head>
<body>
<form method="post" action="payfort1.php">
	<input type="text" name="card_number" placeholder="Card Number" >
	<input type="text" name="card_security_code" placeholder="CSV">
	<input type="text" name="expire_year" placeholder="Expire Year">
	<input type="text" name="expire_month" placeholder="Expire Month">
	<input type="text" name="card_holder_name" placeholder="Card Holder">
	<input type="submit" value="Process">
</form>
</body>
</html>
