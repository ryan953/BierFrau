#!/usr/bin/php
<?php
ini_set("memory_limit","256M");

include('functions.php');
include('simple_html_dom.php');

$save_to_db = true;
$use_local = false;
//$readDetails = false;
$localDir = './mirrored_pages/';

$database = array(
	'host' => 'mysql.ryan953.com',
	'login' => 'app_access',
	'password' => 'j85x7Tug',
	'database' => 'com_ryan953_beerprice',
);


if ($save_to_db) {
	getDB($database);
}


pr('Creating a DOM object from search_url');
$page = 0;
$haveresults = false;
do {
	$page += 1;
	$search_dom = getDomPage(
		array(
			'url'=>"http://lcbo.com/lcbo-ear/lcbo/product/searchResults.do
				?ITEM_NAME=
				&KEYWORDS=
				&ITEM_NUMBER=
				&productListingType=
				&LIQUOR_TYPE_SHORT_=*
				&CATEGORY_NAME=*
				&SUB_CATEGORY_NAME=*
				&PRODUCING_CNAME=*
				&PRODUCING_REGION_N=*
				&UNIT_VOLUME=*
				&SELLING_PRICE=*
				&LTO_SALES_CODE=N
				&VQA_CODE=N
				&KOSHER_CODE=N
				&VINTAGES_CODE=N
				&VALUE_ADD_SALES_CO=N
				&AIR_MILES_SALES_CO=N
				&language=EN
				&style=+LCBO.css
				&sort=sortedProduct
				&order=1
				&resultsPerPage=5
				&page=1
				&action=result
				&sortby=sortedProduct
				&orderby=",
				//&numPerPage=5",
			'file'=>"{$localDir}lcbo-search_{$page}.html",
			'local'=> $use_local
		)
	);

	pr('Reading all Beer/Wine Names and Details URLs from DOM');
	$beverages[$page] = readBeverageNames($search_dom); //read all beer name's from the search_url

} while($haveresults);

pr($beverages);

/*
foreach ($beers as $name=>$val) {
	pr("Loading {$name}");

	if (!empty($val['details_url']) && $readDetails) {
		pr("Creating DOM object: details");
		$details = getDomPage(
			array(
				'url'=>$val['details_url'],
				'file'=>"{$localDir}details_{$name}.html",
				'local'=> $use_local
			)
		);

		pr("Reading Details");
		$val_details = readBeerDetails($details);
		$details = null;
		$val = array_merge($val, $val_details);
		$val_details = null;
	}

	if (!empty($val['prices_url'])) {
		pr("Creating DOM object: prices");
		$prices = getDomPage(
			array(
				'url'=>$val['prices_url'],
				'file'=>"{$localDir}prices_{$name}.html",
				'local'=> $use_local
			)
		);

		pr("Reading Prices");
		$val_prices = readBeerPrices($prices);
		$prices = null;

		$val = array_merge($val, $val_prices);
		$val_prices = null;
	}

	foreach ($val['prices'] as $i=>$price) {
		$val['prices'][$i] = splitPriceData($price);
	}

	$time = time();

	if (empty($name) || !$save_to_db) {
		continue;
	}

	$beer_id = getId('brands', 'name', $name);

	if (empty($beer_id)) {
		$brewer_id = getId('brewers', 'name', $val['brewer']);
		if (empty($brewer_id)) {
			mysql_query("INSERT INTO brewers (name) VALUES ('{$val['brewer']}')");
			$brewer_id = mysql_insert_id();
		}

		$type_id = getId('types', 'name', $val['type']);
		if (empty($type_id)) {
			mysql_query("INSERT INTO types (name) VALUES ('{$val['type']}')");
			$type_id = mysql_insert_id();
		}

		mysql_query("INSERT INTO brands (name, brewer_id, type_id, percent, year) VALUES ('{$val['name']}', {$brewer_id}, {$type_id}, {$val['percent']}, 0);");
		$beer_id = mysql_insert_id();
	}

	foreach((array)$val['prices'] as $price) {
		//insert price with datestamp
		$package_id = getId('packages', 'name', $price['packageName']);
		if (empty($package_id)) {
			$container_id = getId('containers', 'name', $price['containerName']);
			if (empty($container_id)) {
				mysql_query("INSERT INTO containers (name, volume_amount, volume_unit) VALUES ('{$price['containerName']}', {$price['containerVolumeAmount']}, '{$price['containerVolumeUnit']}')");
				$container_id = mysql_insert_id();
			}

			mysql_query("INSERT INTO packages (name, quantity, container_id) VALUES ('{$price['packageName']}', {$price['containerQuantity']}, {$container_id})");
			$package_id = mysql_insert_id();
		}

		mysql_query("INSERT INTO prices (amount, brand_id, package_id, location_id, timestamp) VALUES ({$price['price']}, {$beer_id}, {$package_id}, 1, UNIX_TIMESTAMP())");
	}

	$count = count($val['prices']);
	$complete++;
	pr("Beer_id {$beer_id} has {$count} prices");
	pr("Completed {$complete}, " . (count($beers) - $complete) . " to go");
}
pr('Done');
*/
?>