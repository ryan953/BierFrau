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

	function package($package_id) {
		$this->set('brands',
			$this->Brand->find('all',
				array(
					'contain'=>array(
						'Price'=>array(
							'conditions'=>array('Price.package_id'=>$package_id)
						)
					),
					'order'=>'name ASC'
				)
			)
		);
		$this->render('index');
	}

	function top10() {
		$this->set('brands',
			$this->Brand->findTop10()
		);
		//uses a similar view to index, just without headings
	}


	function view($id) {
		$this->set('brand',
			$this->Brand->find('first',
				array(
					'contain'=>array(
						'Currentprice'=>array(
							'Package'=>array('Container'),
							'Location'),
						'Brewer',
						'Type'
					),
					'conditions'=>array('Brand.id'=>$id)
				)
			)
		);
	}
	function random() {
		$this->set('brand',
			$this->Brand->find('first',
				array(
					'contain'=>array(
						'Currentprice'=>array(
							'Package'=>array('Container'),
							'Location'),
						'Brewer',
						'Type'
					),
					'order'=>'rand()'
				)
			)
		);
		$this->render('view');
	}
}
?>