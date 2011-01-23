<?php
class BrewersController extends AppController {
	var $name = 'Brewers';
	var $scaffold = 'admin';

	function index() {
		$this->set('title_for_layout', "Prices for all brewers making beer sold in `The Beer Store`");
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

	function view($id = null) {
		if (is_null($id)) { $id = $this->params['id']; }
		$brewer = $this->Brewer->find('first',
			array(
				'contain'=>array(
					'Brand'=>array('Type'),
				),
				'conditions'=>array('Brewer.id'=>$id)
			)
		);
		$this->set('title_for_layout', "Prices for beers brewed by {$brewer['Brewer']['name']}");
		$this->set('brewer', $brewer);
	}
}
?>