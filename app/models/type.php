<?php
class Type extends AppModel {
	var $name = 'Type';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Brand'
	);

	function afterFind($results, $primary) {
		$results = ($primary ? $results : array($results));
		foreach($results as $key=>$val) {
			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/brands/type/{$val[$this->name]['id']}";
			}
			$results[$key] = $val;
		}
		return ($primary ? $results : $results[0]);
	}
}
?>