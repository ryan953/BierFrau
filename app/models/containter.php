<?php
class Container extends AppModel {
	var $name = 'Container';
	
	var $belongsTo = array();
	
	var $hasOne = array();
	
	var $hasMany = array(
		'Package'	
	);
}
?>