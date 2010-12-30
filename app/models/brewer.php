<?php
class Brewer extends AppModel {
	var $name = 'Brewer';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Brand'
	);

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {

			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/brewers/{$val[$this->name]['id']}";
			}
			if (isset($val[$this->name]['name'])) {
				$val[$this->name]['name'] = ucwords(strtolower($val[$this->name]['name']));
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>