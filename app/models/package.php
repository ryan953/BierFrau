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
			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/packages/type/{$val[$this->name]['id']}";
			}

			$results[$key] = $val;
		}
		return ($primary ? $results : $results[0]);
	}

	function findCommon() {
		$top_10 = array(
			3,  // 24 Bottle (341ml)
			10, // 12 Bottle (341ml)
			9,  // 6 Bottle (341ml)
			13, // 24 Cans (355ml)
			12, // 12 Cans (355ml)
			5,  // 24 Cans (473ml)
			4,  // 1 Cans (473ml)
			11, // 6 Cans (355ml)
			36, // 1 Keg (30L)
			24  // 12 Cans (473ml)
		);
		$records = $this->find('all', array(
			'contain'=>'Price',
			'conditions'=>array('id'=>$top_10)
		) );

		foreach ($records as $key=>$val) {
			if (isset($val['Package']['id']) && in_array($val['Package']['id'], $top_10)) {
				$val['Package']['top_10'] = array_search($val['Package']['id'], $top_10) + 1;
			}
			$records[$key] = $val;
		}

		return Set::sort($records, '{n}.Package.top_10', 'asc');
	}
}
?>