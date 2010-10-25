<?php
class Package extends AppModel {
	var $name = 'Package';

	var $belongsTo = array(
		'Container'
	);

	var $hasOne = array();

	var $hasMany = array(
		'Price'
	);

	function afterFind($results, $primary) {
		$results = ($primary ? $results : array($results));
		foreach($results as $key=>$val) {
			if (isset($val['Container']) && isset($val['Container']['volume_litre']) &&
				isset($val['quantity'])) {
				$val['volume'] = $val['Container']['volume_litre'] * $val['quantity'];
			}

			$results[$key] = $val;
		}
		return ($primary ? $results : $results[0]);
	}
}
?>