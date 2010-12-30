<?php
class Container extends AppModel {
	var $name = 'Container';

	var $belongsTo = array();

	var $hasOne = array();

	var $hasMany = array(
		'Package'
	);

	function afterFind($results, $primary) {
		foreach($results as $key=>$val) {

			if (isset($val[$this->name]['volume_unit']) && isset($val[$this->name]['volume_amount'])) {
				$val[$this->name]['volume_litre'] = $this->getVolumeInLitres(
					$val[$this->name]['volume_unit'],
					$val[$this->name]['volume_amount']
				);
			}

			$results[$key] = $val;
		}

		if (!$primary) {
			if (isset($results['volume_unit']) && isset($results['volume_amount'])) {
				$results['volume_litre'] = $this->getVolumeInLitres(
					$results['volume_unit'], $results['volume_amount']
				);
			}
		}

		return $results;
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