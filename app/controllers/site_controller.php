<?php
class SiteController extends AppController {
	var $name = 'Site';
	var $uses = array();

	function index() {
		//redirect based on user-agent, etc.
		$this->redirect('/home.jqm');
	}

	function home() {
		$this->set('title_for_layout', "Get more beer for your money");
	}
	function favs() { }

	function about() {
		$this->set('title_for_layout', "Made by Ryan and Nox, we love our beer");
	}
	function api() {
		$this->set('title_for_layout', "Get Beer Price Data in JSON format");
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
