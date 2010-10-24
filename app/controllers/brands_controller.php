<?php
class BrandsController extends AppController {
	var $name = 'Brands';
	var $scaffold = 'admin';

	function index() {
		if ($this->RequestHandler->responseType() == 'json') {
			$this->set('brands',
				$this->Brand->find('all',
					array('contain'=>false, 'order'=>'name ASC')
				)
			);
		} else {
			$this->set('brands', $this->Brand->find('all', array(
				'contain'=>array(
					'Type',
					'Brewer',
					'Price'
				),
				'limit'=>10
			) ) );

			/*
			'Price'=>array(
				'Package'=>array(
					'Container'
				),
				'Location'
			)
			*/
			$this->set('packages', $this->Brand->Price->Package->find('all'));
			$this->set('locations', $this->Brand->Price->Location->find('all'));
		}
	}


}
?>