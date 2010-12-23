<?php
class Currentprice extends AppModel {
	var $name = 'Currentprice';

	var $belongsTo = array(
		'Brand', 'Package', 'Location'
	);

	var $hasOne = array();

	var $hasMany = array();

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {
			foreach($val['Currentprice'] as $k2=>$price) {

				if (isset($price['Package']) && isset($price['Package']['volume']) &&
					isset($price['amount'])) {
					$price['price_per_litre'] = $price['amount'] / $price['Package']['volume'];
				}

				$results[$key]['Currentprice'][$k2] = $price;
			}
		}
		return $results;
	}
}
?>
