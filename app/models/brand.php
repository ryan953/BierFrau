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

	function afterFind($results) {
		foreach($results as $key=>$val) {
			if (isset($val[$this->name]['id'])) {
				$val[$this->name]['url'] = "/brands/view/{$val[$this->name]['id']}";
			}

			$results[$key] = $val;
		}
		return $results;
	}
}
?>