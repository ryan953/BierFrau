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
			foreach($val[$this->name] as $k2=>$price) {

				if (isset($price['Package']) && isset($price['Package']['volume']) &&
					isset($price['amount'])) {
					$price['price_per_litre'] = $price['amount'] / $price['Package']['volume'];
				}

				$results[$key][$this->name][$k2] = $price;
			}
		}
		return $results;
	}
}
?>