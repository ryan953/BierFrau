<?php
class BrandsController extends AppController {
	var $name = 'Brands';
	var $scaffold = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		switch ($this->action) {
		case 'top10':
		case 'index_byBrewer':
		case 'index_byType':
			$this->ServerResponse->setMethodType('view');
			break;
		}
	}

	function index() {
		$this->set('title_for_layout', "Prices for all brands in Ontario's `The Beer Store`");

		$conditions = array();
		if (!empty($this->params['brewer_id'])) {
			$conditions = array('brewer_id'=>$this->params['brewer_id']);
		}
		$this->set('brands',
			$this->Brand->find('all',
				array(
					'contain'=>array('Type', 'Brewer'),
					'order'=>'Brand.name ASC',
					'conditions'=>$conditions
				)
			)
		);
	}

	function index_byBrewer() {
		$conditions = array('brewer_id'=>$this->params['brewer_id']);
		$brands = $this->Brand->find('all',
			array(
				'contain'=>array('Type'),
				'order'=>'Brand.name ASC',
				'conditions'=>$conditions
			)
		);

		$this->set('title_for_layout', "Prices for {$brands['Brands']['name']}");
		$this->set('brands', $brands);
		$this->render('index');
	}

	function top10() {
		$this->set( 'title_for_layout', "Top 10 Beer Brands and Prices in Ontario's `The Beer Store`" );
		$this->set('brands',
			$this->Brand->findTop10()
		);
		//uses a similar view to index, just without headings
	}


	function view($id = null) {
		if (is_null($id)) { $id = $this->params['id']; }

		$brand = $this->Brand->find('first',
			array(
				'contain'=>array(
					'Currentprice'=>array(
						'Package'=>array('Container'),
						'Location'
					),
					'Brewer',
					'Type'
				),
				'conditions'=>array('Brand.id'=>$id)
			)
		);
		$this->set('title_for_layout', "{$brand['Brand']['name']} Prices at `The Beer Store`");
		$this->set('brand', $brand);
	}

	function random() {
		$rand_id = rand(1, $this->Brand->find('count'));
		$this->redirect( array(
			'action'=>'view',
			$rand_id . '.' . $this->params['url']['ext']
		), 303 );
	}


	/*function type($type_id) {
		$this->set('brands',
			$this->Brand->find('all',
				array(
					'contain'=>false, 'order'=>'name ASC',
					'conditions'=>array('Brand.type_id'=>$type_id)
				)
			)
		);
		$this->render('index');
	}*/

	/*function package($package_id) {
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
	}*/
}
?>