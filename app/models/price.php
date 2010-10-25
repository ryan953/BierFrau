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
			foreach($val['Price'] as $k2=>$price) {

				if (isset($price['Package']) && isset($price['Package']['volume']) &&
					isset($price['amount'])) {
					$price['price_per_litre'] = $price['amount'] / $price['Package']['volume'];
				}

				$results[$key]['Price'][$k2] = $price;
			}
		}
		return $results;
	}
}
?>