<?php
class Brewer extends AppModel {
	var $name = 'Brewer';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Brand'
	);

	function afterFind($results) {
		foreach($results as $key=>$val) {
			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/brewers/view/{$val[$this->name]['id']}";
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>