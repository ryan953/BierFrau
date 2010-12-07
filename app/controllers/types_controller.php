<?php
class TypesController extends AppController {
	var $name = 'Types';
	var $scaffold = 'admin';

	function index() {
		$this->set('types',
			$this->Type->find('all',
				array('contain'=>'Brand')
			)
		);
	}
}
?>