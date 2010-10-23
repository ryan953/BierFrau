<?php
class ContainersController extends AppController {
	var $name = 'Containers';
	var $scaffold = 'admin';
	
	function index() {
		$this->set('containers', $this->Container->find('all'));
	}

}
?>