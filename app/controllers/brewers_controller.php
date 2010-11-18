<?php
class BrewersController extends AppController {
	var $name = 'Brewers';
	var $scaffold = 'admin';

	function index() {
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

	function view($id) {
		$this->set('brewer',
			$this->Brewer->find('first',
				array(
					'contain'=>array(
						'Brand'=>array('Type'),
					),
					'conditions'=>array('Brewer.id'=>$id)
				)
			)
		);
	}
}
?>