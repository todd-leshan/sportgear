<?php 

$toAddress  = $order['email'];

$subject = 'Thanks for shopping with us!';

$message = "
<html>
<head>
	<title>This is the confirmation letter of your order!</title>
</head>

<body>

			<p>Dear ".$order['firstname']." ".$order['lastname'].",</p>
			<p>Thanks for shopping with <a href='localhost/sportgear'>Sportgear</a></p>
			<p>Your order number is ".$orderNo."</p>
			<p>You can track your order with your order number and email address!</p>
			<p>SportGear.com</p>
			<p>".Date("d/M/Y")."</p>

</body>
</html>
";

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: SportGear Contact Board' . "\r\n";

// Mail it

if(mail($toAddress, $subject, $message, $headers))
{
?>
	<div id="wrapper" class="clearFix container">

		<p>Dear <?php echo $customer; ?>:</p>
		<p>Thanks for shopping with us!</p>
		<p>Your order number is: <?php echo $orderNo; ?></p>
		<p>You can track your order with this number at any time with us.</p>

		<p class="goBack"><a href="<?php echo ROOT; ?>">Continue shopping</a></p>

	</div>
<?php
}
else
{
?>
	<div id="wrapper" class="clearFix container">
		<p class="error_show">System error! We will contact you later to confirm your order via email! Sorry for any inconvenience!</p>
		<p class="goBack"><a href="<?php echo ROOT; ?>">Continue shopping</a></p>
	</div>
<?php
}
?>
