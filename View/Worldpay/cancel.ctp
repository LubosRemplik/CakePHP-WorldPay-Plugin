<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Payment cancelled</title>
		<meta http-equiv="refresh" content="5;URL='<?php echo Configure::read('Worldpay.cancel-url'); ?>'">
		<style>
		body {
			font-family: 'Arial', sans-serif;
			background: #EFEFEF;
		}
		</style>
	</head>
	<body>
		<h1><?php echo $this->Html->image(
			Configure::read('App.logo'),
			array('alt' => Configure::read('App.name'), 'fullBase' => true)
		) ?></h1>
		<p>Your payment was cancelled. You will be redirected to the website in 5 sec, or click <?php echo $this->Html->link('here', Configure::read('Worldpay.cancel-url')); ?> to continue</p>
	</body>
</html>
