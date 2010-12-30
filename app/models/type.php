<?php
class Type extends AppModel {
	var $name = 'Type';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Brand'
	);

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {

			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/types/{$val[$this->name]['id']}/brands";
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>