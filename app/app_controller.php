<?php
class AppController extends Controller {
	var $components = array('RequestHandler');

	function beforeFilter() {
		parent::beforeFilter();

		App::import('Sanitize');

		$this->RequestHandler->setContent(array(
			'jqm'=>'text/html',
			'jqt'=>'text/html'
		));

		//Load our custom config file
		//Configure::load('calendar');
	}

}
?>