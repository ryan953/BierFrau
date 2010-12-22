<?php
class MobileController extends AppController {
	var $name = 'Mobile';
	var $uses = array();

	function home() {
		//$this->layout = 'jqtouch';
		$this->layout = 'jqmobile';
		$this->render('jqm/home');
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
