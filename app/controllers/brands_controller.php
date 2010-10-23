<?php
class BrandsController extends AppController {
	var $name = 'Brands';
	var $scaffold = 'admin';

	function index() {
		$this->layout = '960';
		//$this->set('brands', $this->Brand->find('all', array('contain'=>array('Type', 'Brewer'))) );
		$this->set('brands', $this->Brand->find('all',
			array(
				'contain'=>array(
					'Type',
					'Brewer',
					'Price'
				),
				'limit'=>10
			)
		) );
		$this->set('packages', $this->Brand->Price->Package->find('all'));
		$this->set('locations', $this->Brand->Price->Location->find('all'));
	}
/*
'Price'=>array(
	'Package'=>array(
		'Container'
	),
	'Location'
)
*/
}
?>