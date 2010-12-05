<?php
class Brand extends AppModel {
	var $name = 'Brand';

	var $belongsTo = array(
		'Brewer', 'Type'
	);

	var $hasOne = array();

	var $hasMany = array(
		'Price'
	);

	/*var $validate = array(
		'name' => array(
			'rule' => 'alphaNumeric',
			'required'=>true
		),
		'percent' => array(
			'rule' => ''
		),
		'location' => array(

			'required' => false
		),
		'year' => array(
			'rule' => array('between', 500, 2100),
			'required' => false
		)
	);*/

	function afterFind($results, $primary) {
		$results = ($primary ? $results : array($results));
		foreach($results as $key=>$val) {
			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/brands/view/{$val[$this->name]['id']}";
			}
			if (isset($val[$this->name]['name'])) {
				$val[$this->name]['name'] = ucwords($val[$this->name]['name']);
			}
			$results[$key] = $val;
		}
		return ($primary ? $results : $results[0]);
	}

	function findTop10() {
		$top_10 = array(
			43, // Coors Light
			33, // Molson Canadian
			26, // Budweiser
			18, // Blue
			296,// Carling Lager
			23, // Bud Light
			69, // Alexander Keiths India Pale Ale
			313,// Lakeport Pilsner
			292,// Brava Premium Lager
			203 // Corona Extra
		);
		$records = $this->find('all', array(
			'contain'=>false,
			'conditions'=>array('id'=>$top_10)
		) );

		foreach ($records as $key=>$val) {
			if (isset($val['Brand']['id']) && in_array($val['Brand']['id'], $top_10)) {
				$val['Brand']['top_10'] = array_search($val['Brand']['id'], $top_10) + 1;
			}
			$records[$key] = $val;
		}

		return Set::sort($records, '{n}.Brand.top_10', 'asc');

	}
}
?>