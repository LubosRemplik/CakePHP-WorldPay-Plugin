<?php
App::uses('AppController', 'Controller');
class WorldpayController extends AppController {

	public $uses = array(
		'Shop.ShopOrder'	
	);

	public $helpers = array(
		'AssetCompress.AssetCompress'
	);

	public function index() {
		if ($this->request->is('post')) {
			if ($this->request->data['transStatus'] == 'Y') {
				$this->ShopOrder->id = $this->request->data['cartId'];
				$this->ShopOrder->saveField('status', 1);
				return $this->render('index', false);
			} elseif ($this->request->data['transStatus'] == 'C') {
				return $this->render('cancel', false);
			}
		}
	}
}
