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

	function random() {
		$this->set('brand',
			$this->Brand->find('first',
				array(
					'contain'=>array('Price'=>array('Package'=>array('Container'), 'Location'), 'Brewer', 'Type'),
					'order'=>'rand()'
				)
			)
		);
		$this->render('view');
	}

	function view($id) {
		$this->set('brand',
			$this->Brand->find('first',
				array(
					'contain'=>array('Price'=>array('Package'=>array('Container'), 'Location'), 'Brewer', 'Type'),
					'conditions'=>array('Brand.id'=>$id)
				)
			)
		);
	}

	function type($type_id) {
		$this->set('brands',
			$this->Brand->find('all',
				array(
					'contain'=>false, 'order'=>'name ASC',
					'conditions'=>array('Brand.type_id'=>$type_id)
				)
			)
		);
		$this->render('index');
	}


}
?>