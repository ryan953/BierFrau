<?php
class Price extends AppModel {
	var $name = 'Price';
	
	var $belongsTo = array(
		'Brand', 'Package', 'Location'
	);
	
	var $hasOne = array();
	
	var $hasMany = array(
		
	);
}
?>