<?php
class PackagesController extends AppController {
	var $name = 'Packages';
	var $scaffold = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		switch ($this->action) {
		case 'common':
			$this->ServerResponse->setMethodType('view');
			break;
		}
	}

	function index() {
		$this->set('title_for_layout', "Beer prices by package: case of 24, 12-pack, 6-pack and more");
		$this->set('packages', $this->Package->find('all', array('contain'=>array('Container'))));
	}

	function common() {
		$this->set('title_for_layout', "Prices for popular beer packages");
		$this->set('packages',
			$this->Package->findCommon()
		);
	}
}
?>