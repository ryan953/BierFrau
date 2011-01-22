<?php
class MobileController extends AppController {
	var $name = 'Mobile';
	var $uses = array();

	function home() {
		//$this->layout = 'jqtouch';
		$this->layout = 'jqmobile';
		$this->render('jqm/home');
	}

	function sitemap() {
		$this->helpers[] = 'Sitemap';

		$this->loadModel('Brewers');
		$this->loadModel('Brands');
		$this->loadModel('Packages');
		$this->loadModel('Types');

		$brewers = $this->Brewers->find('all', array('fields'=>array('id')));
		$brands = $this->Brands->find('all', array('fields'=>array('id')));
		$packages = $this->Packages->find('all', array('fields'=>array('id')));
		$types = $this->Types->find('all', array('fields'=>array('id')));

		$this->set(compact('brewers', 'brands', 'packages', 'types'));

		$this->render('/pages/sitemap');
	}

	/*function cache_manifest() {
		$this->layout = 'cache_manifest';
		$this->render('jqm/cache_manifest');
	}

	function offline() {
		$this->layout = 'jqmobile';
		$this->render('jqm/offline');
	}*/
}
?>
