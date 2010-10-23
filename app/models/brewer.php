<?php
class Brewer extends AppModel {
	var $name = 'Brewer';
	
	var $belongsTo = array();
	
	var $hasOne = array();
	
	var $hasMany = array(
		'Brand'
	);
}
?>