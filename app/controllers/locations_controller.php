<?php
class LocationsController extends AppController {
	var $name = 'Locations';
	var $scaffold = 'admin';
	
	function index() {
		$this->set('locations', $this->Location->find('all'));
	}

}
?>