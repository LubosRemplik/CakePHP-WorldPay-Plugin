# CakePHP WorldPay Plugin

This is plugin for ecommerce payment gateway service [www.worldpay.com](http://www.worldpay.com)


## Requirements

[CakePHP v2.x](https://github.com/cakephp/cakephp)   


## Install & Config

1.	Checkout the plugin into Plugin folder

		cd app/Plugin
		git clone https://github.com/LubosRemplik/CakePHP-WorldPay-Plugin.git Worldpay

1.	Add the plugin into list of plugins in app/Config/bootstrap.php
		
		// in app/Config/bootstrap.php
		CakePlugin::load('Worldpay', array('bootstrap' => true));
		

1.	Copy app/Plugin/Worldpay/bootstrap.php.default to app/Plugin/Worldpay/bootstrap.php and amend values in the files.


Also log into [Mecharn admin](https://secure.worldpay.com/sso/public/auth/login.html?serviceIdentifier=merchantadmin) and amend your Installations settings

For this plugin I changed Payment Response URL to
http://example.com/worldpay/worldpay/index

"Payment Response enabled?" and "Enable the Shopper Response" are checked


## Usage

Add Worldpay.Worldpay into your helpers list and use it at the end of shopping process, in your worldpay view add

	<?php
	echo $this->Worldpay->form(array(
		'cartId' => $data['ShopOrder']['uid'], // your cart / order id
		'amount' => $data['ShopOrder']['total'], // total amount to be paid
	));

If you use Mecharn admin configuration suggested above, check WorldpayController, the POST from worldpay is process there and it is giving thank you page back to worldpay. Controller assumes you use Shop.ShopOrder model and changes status field


## Testing

To test your payment process (in test mode) use

Card number: 5555555555554444  
Security Code: leave empty  
Expiry date: random date (max 5 years in future)

Then fill in all required fields with dummy details


## Documentation

WorldPay guides can be found [here](http://www.worldpay.com/support/bg/index.php?page=guides)

Read "Submitting Transactions to our Hosted Payment Page (HTML Redirect)" and "Payment Notifications"


## Issues

If you have any issue/question please submit it into [issue tracker](https://github.com/LubosRemplik/CakePHP-WorldPay-Plugin/issues)
