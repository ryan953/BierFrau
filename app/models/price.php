<?php
class Price extends AppModel {
	var $name = 'Price';

	var $belongsTo = array(
		'Brand', 'Package', 'Location'
	);

	var $hasOne = array();

	var $hasMany = array();

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {

			if ( isset($val['Package']) &&
			isset($val['Package']['volume']) &&
			isset($val[$this->name]['amount']) ) {
				$val[$this->name]['price_per_litre'] = $val[$this->name]['amount'] / $val['Package']['volume'];
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>