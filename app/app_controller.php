<?php
class AppController extends Controller {
	public $components = array(
		'RequestHandler',
		'json_api.ServerResponse',
		'json_api.RequestData' => array(
			'key' => 'myData', // Named and query string parameters are stored in the $controller->params[$key]. $key defaults to 'requestData'
			'named' => true,  // Whether or not to merge named parameters in
			'query' => true   // Whether or not to merge query string parameters in
		)
	);

	function beforeFilter() {
		parent::beforeFilter();

		App::import('Sanitize');

		$this->RequestHandler->setContent(array(
			'jqm'=>'text/html',
			'jqt'=>'text/html'
		));

		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		}

		//Load our custom config file
		//Configure::load('calendar');
	}

}
?>