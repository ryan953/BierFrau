<?php
function pr($data) {
	print_r($data);
	echo "\n";
}

function getDomPage($params) {
	if (!$params['local']) {
		$params['url'] = preg_replace("/\s+/", "", $params['url']);
		pr($params['url']);
		pr($params['file']);

		$fp = fopen($params['file'], "w");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $params['url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$ch = null;
		$fp = null;
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
	$recordSet = mysql_query(sprintf("SELECT * FROM %s", $table));
	$rtrn = array();
	while($row = mysql_fetch_assoc($recordSet)) {
		$rtrn[] = $row;
	}
	return $row;
}

function lookup($table, $field, $value) {
	$recordSet = mysql_query(sprintf("SELECT %s FROM %s WHERE %s='%s' LIMIT 1", $field, $table, $field, $value));
	return mysql_fetch_assoc($recordSet);
}

function getId($table, $field, $value) {
	$recordSet = mysql_query(sprintf("SELECT id FROM %s WHERE %s='%s'", $table, $field, $value));
	$rtrn = mysql_fetch_assoc($recordSet);
	return $rtrn['id'];
}



function getDB($database_opts) {
	$link = mysql_connect($database_opts['host'], $database_opts['login'], $database_opts['password'])
		or die('Could not connect: ' . mysql_error());
	echo "Connected successfully\n";
	mysql_select_db($database_opts['database']) or die('Could not select database');
	return $link;
}



function readBeverageNames($dom) {
	$found = array();
	$elems = $dom->find('table table table table table table table table table tr');
	array_shift($elems);
	array_shift($elems);
	foreach($elems as $element) {
		$item = $element->find('td', 1);

		$name = $item->find('b a', 0)->plaintext;
		$found[$name]['name'] = $name;

		$raw_meta = explode('|', $item->find('font', 0)->innertext);
		foreach($raw_meta as $k=>$v) {
			$raw_meta[$k] = preg_replace("/\s+/", " ", trim($v));
		}
		$found[$name]['country'] = $raw_meta[0];
		list($found[$name]['brewer'], $found[$name]['lcbo_num']) = explode('<br>', $raw_meta[1]);
		list($found[$name]['size'], $more) = explode('<br>', $raw_meta[2]);

		list($found[$name]['volume_amount'], $found[$name]['volume_unit']) = explode(' ', $found[$name]['size']);
		$found[$name]['volume_unit'] = strtoupper($found[$name]['volume_unit']);
		$found[$name]['more'] = $more;

		$found[$name]['price'] = str_replace('$ ', '', str_replace('NOW:&nbsp;', '', strip_tags($raw_meta[3])));
		//$found[$name]['meta'] = $raw_meta;


		//pr(preg_replace("/\s+/", " ", $other->plaintext));

		//$name_elem = $data->outertext;
		//pr($name_elem->plaintext);





		/*if (strpos($element->href, 'branddetails.asp?id=') === 0) {
			//$brand_id = str_replace('branddetails.asp?id=', '', $element->href);

			$name_elem = $element->find('b', 0);
			$brand_name = ucwords(strtolower(
				print_r($name_elem->plaintext, true)
			));

			$found[$brand_name] = array(
				'name'=>$brand_name,
				//'details_url'=>"http://www.thebeerstore.ca/Beers/{$element->href}",
				//'prices_url'=>"http://www.thebeerstore.ca/Beers/pricelist.asp?id={$brand_id}"
			);
		}*/

	}
	$dom = null;
	return $found;
}
?>