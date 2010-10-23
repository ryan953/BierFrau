<?php
class Type extends AppModel {
	var $name = 'Type';
	
	var $belongsTo = array();
	
	var $hasOne = array();
	
	var $hasMany = array(
		'Brand'
	);
}
?>