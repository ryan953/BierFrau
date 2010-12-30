<?php
class PricesController extends AppController {
	var $name = 'Prices';
	var $scaffold = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		switch ($this->action) {
		case 'index_byPackage':
		case 'index_byBrand':
		case 'index_byBrandPackage':
			$this->ServerResponse->setMethodType('view');
			break;
		}
	}

	function index() {
		$this->set('prices', $this->Price->find('all'));
	}

	function index_byPackage() {
		$this->set('prices',
			$this->Price->find('all',
				array(
					'contain'=>array(
						'Package'=>array('Container'),
						'Location'
					),
					'order'=>'timestamp DESC',
					'conditions'=>array('package_id'=>$this->params['package_id'])
				)
			)
		);
	}

	function index_byBrand() {
		$this->set('prices',
			$this->Price->find('all',
				array(
					'contain'=>array(
						'Package'=>array('Container'),
						'Location'
					),
					'order'=>'timestamp DESC',
					'conditions'=>array('brand_id'=>$this->params['brand_id'])
				)
			)
		);
	}

	function index_byBrandPackage() {
		$this->set('prices',
			$this->Price->find('all',
				array(
					'contain'=>array(
						'Package'=>array('Container'),
						'Location'
					),
					'order'=>'timestamp DESC',
					'conditions'=>array(
						'brand_id'=>$this->params['brand_id'],
						'package_id'=>$this->params['package_id']
					)
				)
			)
		);
	}

	function view($id) {
		$this->set('prices', $this->Price->find('all', array(
				'conditions'=>array('brand_id'=>$id),
				'contain'=>array('Package')
			) )
		);
	}
}
?>