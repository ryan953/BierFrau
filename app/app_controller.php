<?php
class AppController extends Controller {
	var $components = array('RequestHandler');

	function beforeFilter() {
		parent::beforeFilter();

		App::import('Sanitize');

		$this->set('accepts_xhtml', $this->RequestHandler->accepts('xhtml'));
		$this->RequestHandler->setContent('json', 'text/x-json');

		//Load our custom config file
		//Configure::load('calendar');
	}

}
?>