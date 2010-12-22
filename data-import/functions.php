<?php
function pr($data) {
	print_r($data);
	echo "\n";
}

function getDomPage($params) {
	if (!$params['local']) {
		pr($params['file']);

		$fp = fopen($params['file'], "w");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $params['url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$fp = null;
		$ch = null;
	}

	$dom = file_get_html($params['file']);

	return $dom;
}

function readBeerNames($dom) {
	$found = array();
	foreach($dom->find('a') as $element) {
		if (strpos($element->href, 'branddetails.asp?id=') === 0) {
			$brand_id = str_replace('branddetails.asp?id=', '', $element->href);

			$name_elem = $element->find('b', 0);
			$brand_name = ucwords(strtolower(
				print_r($name_elem->plaintext, true)
			));

			$found[$brand_name] = array(
				'name'=>$brand_name,
				'details_url'=>"http://www.thebeerstore.ca/Beers/{$element->href}",
				'prices_url'=>"http://www.thebeerstore.ca/Beers/pricelist.asp?id={$brand_id}"
			);
		}
	}
	$dom = null;
	return $found;
}

function readBeerDetails($dom) {
	$text = $dom->find('#table3 > tbody > tr', 1)->find('td', 1)->firstchild()->innertext;
	$text = explode('<p>', $text);
	$text = $text[0];

	$fields = explode('<br>', $text);

	$brewer = explode('</b>', $fields[0]);
	$percent = explode('</b>', $fields[1]);
	$type = explode('</b>', $fields[2]);

	$brewer = $brewer[1];
	$percent = str_replace("%", '', $percent[1]);
	$type = $type[1];

	$link = $dom->find('#table3 > tbody > tr', 2)->find('a', 0);

	$price_url = "http://www.thebeerstore.ca/Beers/{$link->href}";

	$dom = null;
	return array(
		'brewer'=>trim($brewer),
		'percent'=>trim($percent),
		'type'=>trim($type),
		'price_url'=>trim($price_url)
	);
}

function readBeerPrices($dom) {
	$found = array();

	$table = $dom->find('#table6 table', 0);

	foreach ($table->find('tr') as $row) {
		$type = $row->find('td', 0)->plaintext;
		$price = $row->find('td', 1)->plaintext;

		if ($type != 'All Package Sizes') {
			$found[] = array(
				'type'=>trim($type),
				'price'=>trim($price)
			);
		}
	}
	$row = null;
	$table = null;
	$dom = null;

	return array(
		'prices'=>$found
	);
}


function splitPriceData($price) {
	$parts = explode(' ', $price['type']);
	$price['containerVolumeUnit'] = strtoupper($parts[3]);
	$price['containerVolumeAmount'] = $parts[2];
	$price['containerName'] = "{$parts[1]} ({$price['containerVolumeAmount']}{$price['containerVolumeUnit']})";
	$price['containerQuantity'] = $parts[0];
	$price['packageName'] = "{$price['containerQuantity']} {$price['containerName']}";
	return $price;
}

function selectAll($table) {
	$recordSet = mysql_query("SELECT * FROM {$table}");
	$rtrn = array();
	while($row = mysql_fetch_assoc($recordSet)) {
		$rtrn[] = $row;
	}
	return $row;
}

function lookup($table, $field, $value) {
	$recordSet = mysql_query("SELECT {$field} FROM {$table} WHERE {$field}='{$value}' LIMIT 1");
	return mysql_fetch_assoc($recordSet);
}

function getId($table, $field, $value) {
	$recordSet = mysql_query("SELECT id FROM {$table} WHERE {$field}='{$value}'");
	$rtrn = mysql_fetch_assoc($recordSet);
	return $rtrn['id'];
}



function getDB($database_opts) {
	$link = mysql_connect($database_opts['host'], $database_opts['login'], $database_opts['password'])
		or die('Could not connect: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db($database_opts['database']) or die('Could not select database');
	return $link;
}
?>