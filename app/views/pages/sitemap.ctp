
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$ext = 'jqm';
/*
<url>
	<loc>http://www.example.com/foo.html</loc>
	<lastmod>YYYY-MM-DDThh:mmTZD</lastmod>
	<changefreq>always|hourly|daily|weekly|monthly|yearly|never</changefreq>
</url>
*/

/** Brewers **/
echo $sitemap->url("/brewers.{$ext}");
foreach ($brewers as $item) {
	echo $sitemap->url("/brewers/{$item['Brewers']['id']}.{$ext}");
	echo $sitemap->url("/brewers/{$item['Brewers']['id']}/brands.{$ext}");
}


/** Brands **/
echo $sitemap->url("/brands.{$ext}");
echo $sitemap->url("/brands/top10.{$ext}");
foreach ($brands as $item) {
	echo $sitemap->url("/brands/{$item['Brands']['id']}.{$ext}");
	echo $sitemap->url("/brands/{$item['Brands']['id']}/prices.{$ext}");

	/*foreach ($packages as $package) {
		echo $sitemap->url("/brands/{$item['Brands']['id']}/packages/{$package['Packages']['id']}/prices.json");
	}*/
}

/** Packages **/
echo $sitemap->url("/packages.{$ext}");
echo $sitemap->url("/packages/common.{$ext}");
foreach ($packages as $item) {
	echo $sitemap->url("/packages/{$item['Packages']['id']}/prices.{$ext}");
}

/** Types **/
echo $sitemap->url("/types.{$ext}");
foreach ($types as $item) {
	echo $sitemap->url("/types/{$item['Types']['id']}/brands.{$ext}");
}
?>
</urlset>
