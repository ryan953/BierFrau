<?php
class MobileController extends AppController {
	var $name = 'Mobile';
	var $uses = array();

	function home() {
		//$this->layout = 'jqtouch';
		$this->layout = 'jqmobile';
		$this->render('jqm/home');
	}
}
?>
