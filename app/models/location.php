<?php
class Location extends AppModel {
	var $name = 'Location';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Price'
	);

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {

			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/locations/{$val[$this->name]['id']}/types";
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>