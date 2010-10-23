<?php
class PricesController extends AppController {
	var $name = 'Prices';
	var $scaffold = 'admin';
	
	function index() {
		$this->set('prices', $this->Price->find('all'));
	}
	
	function view($id) {
		$this->set('prices', $this->Price->find('all', array(
				'conditions'=>array('brand_id'=>$id),
				'contain'=>array('Package')
			) )
		);
	}

}
?>