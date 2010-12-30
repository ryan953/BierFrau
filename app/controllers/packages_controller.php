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
		$this->set('packages', $this->Package->find('all', array('contain'=>array('Container'))));
	}

	function common() {
		$this->set('packages',
			$this->Package->findCommon()
		);
	}
}
?>