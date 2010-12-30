<?php
class TypesController extends AppController {
	var $name = 'Types';
	var $scaffold = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		switch ($this->action) {
		case 'index_withBrands':
			$this->ServerResponse->setMethodType('view');
			break;
		}
	}

	function index() {
		$this->set('types',
			$this->Type->find('all',
				array('contain'=>false)
			)
		);
	}

	function index_withBrands() {
		$conditions = array();
		$contain = false;
		if (!empty($this->params['type_id'])) {
			$conditions = array('id'=>$this->params['type_id']);
			$contain = array('Brand');
		}
		$this->set('type',
			$this->Type->find('all',
				array(
					'contain'=>$contain,
					'order'=>'Type.name ASC',
					'conditions'=>$conditions
				)
			)
		);
	}

}
?>