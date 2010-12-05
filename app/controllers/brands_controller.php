<?php
class BrandsController extends AppController {
	var $name = 'Brands';
	var $scaffold = 'admin';

	function index() {
		$this->set('brands',
			$this->Brand->find('all',
				array('contain'=>false, 'order'=>'name ASC')
			)
		);
	}

	function top10() {
		$this->set('brands',
			$this->Brand->findTop10()
		);
	}

	function view($id) {
		$this->set('brand',
			$this->Brand->find('first',
				array(
					'contain'=>array('Price'=>array('Package'=>array('Container'), 'Location'), 'Brewer'),
					'conditions'=>array('Brand.id'=>$id)
				)
			)
		);
	}


}
?>