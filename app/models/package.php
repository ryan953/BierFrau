<?php
class Package extends AppModel {
	var $name = 'Package';
	
	var $belongsTo = array(
		'Container'
	);
	
	var $hasOne = array();
	
	var $hasMany = array(
		'Price'
	);
}
?>