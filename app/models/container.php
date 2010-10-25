<?php
class Container extends AppModel {
	var $name = 'Container';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Package'
	);

	function afterFind($results, $primary) {
		$results = ($primary ? $results : array($results));
		foreach($results as $key=>$val) {
			if (isset($val['volume_unit']) && isset($val['volume_amount'])) {
				$val['volume_litre'] = $this->getVolumeInLitres(
					$val['volume_unit'],
					$val['volume_amount']
				);
			}

			$results[$key] = $val;
		}
		return ($primary ? $results : $results[0]); //return $results;
	}

	function getVolumeInLitres($unit, $volume) {
		$unit = strToLower($unit);
		return (
			$unit == 'ml' ? $volume / 1000 :
			$unit = 'l' ? $volume :
			0
		);
	}
}
?>