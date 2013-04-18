<?php
class WorldpayHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'Js');

	private $_paymentUrls = array(
		'test' => 'https://secure-test.worldpay.com/wcc/purchase',
		'live' => 'https://secure.worldpay.com/wcc/purchase'
	);
	
	public function form($options = null) {
		
		extract($options);
		
		$mode = Configure::read('Worldpay.mode');
		if(!$mode) {
			return 'Payment mode not specified';
		}
		if (!in_array($mode, array_keys($this->_paymentUrls))) {
			return "Payment mode not recognized: $mode";
		}
		
		$instId = Configure::read('Worldpay.installation');
		if (!$instId) {
			return 'Worldpay installation ID not found in configuration';
		}
		
		$mandatoryFields = array('cartId', 'amount');
		foreach($mandatoryFields as $field) {
			if (!isset($$field)) {
				return "Missing value: $field";
			}
		}
		
		// Currency
		$currency = Configure::read('Shop.currency');
		
		// Mandatory fields
		$fields = array(
			'instId'	=> array('type'		=> 'hidden', 'name' => 'instId',		'value' => $instId),
			'cartId'	=> array('type'		=> 'hidden', 'name' => 'cartId',		'value' => $cartId),
			'amount'	=> array('type'		=> 'hidden', 'name' => 'amount',		'value' => $amount),
			'currency'	=> array('type'		=> 'hidden', 'name' => 'currency',		'value' => $currency),
			'desc'		=> array('type'		=> 'hidden', 'name' => 'desc',			'value' => implode(' ', array(AppPreference::get('application_name'), __('purchase')))),
			//'authValidTo' => array('type'	=> 'hidden', 'name' => 'authValidTo',	'value' => time()+600*1000)
		);
		
		// Signature
		$signatureFields = array('instId', 'cartId', 'amount', 'currency');
		$signature = array(Configure::read('Worldpay.secret'));
		foreach ($signatureFields as $signatureField) {
			$signature[] = $$signatureField;
		}
		$fields['signature'] = array('type'		=> 'hidden', 'name' => 'signature',	'value' => md5(implode(':', $signature)));
		
		// Custom description
		if (isset($desc)) {
			$fields['desc'] = array('type' => 'hidden', 'name' => 'desc', 'value' => $desc);
		}
		
		// Optional address fields
		$addressFields = array('name', 'address1', 'address2', 'address3', 'town', 'region', 'postcode', 'country', 'tel', 'email');
		foreach ($addressFields as $field) {
			if (isset($$field)) {
				$fields[$field] = array('type' => 'hidden', 'name' => $field, 'value' => $$field);
			}
		}
		
		// Test Mode
		if ($mode == 'test') {
			$fields = array_merge(array(
				'testMode' => array('type' => 'hidden', 'name' => 'testMode', 'value' => '100'),
			), $fields);
		}
		
		// Fix address / contact details
			if(isset($fixContact) and $fixContact) {
			$fields = array_merge(
				array(
					'fixContact'	=> array('type' => 'hidden', 'name' => 'fixContact'),
					'hideContact'	=> array('type' => 'hidden', 'name' => 'hideContact')
				),
				$fields
			);
		}
				
		$js = "$(document).ready(function(){
			var t = setTimeout(function(){
				$('#worldpay-order').submit();
			}, 5000);
		});";
		$this->Js->buffer($js);
		
		return implode('', array(
			$this->Form->create(false, array(
				'url' => $this->_paymentUrls[$mode],
				'id' => 'worldpay-order'
			)),
			$this->Form->inputs(array_merge(
				array(
					'fieldset'	=> false
				),
				$fields
			)),
			$this->Form->submit(__('Proceed to payment gateway')),
			$this->Form->end()
		));
	}
	
}