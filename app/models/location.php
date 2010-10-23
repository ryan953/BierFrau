<?php
class Location extends AppModel {
	var $name = 'Location';

	var $belongsTo = array();
		
	var $hasOne = array();
	
	var $hasMany = array(
		'Price'
	);
}
?>