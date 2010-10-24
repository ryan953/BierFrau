<?php
class BrewersController extends AppController {
	var $name = 'Brewers';
	var $scaffold = 'admin';

	function index() {
		if ($this->RequestHandler->responseType() == 'json') {
			$this->set('brewers',
				$this->Brewer->find('all',
					array(
						'contain'=>false,
						'order'=>'name ASC',
						'conditions'=>array('name !='=>'')
					)
				)
			);
		}
	}
}
?>