
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
	<loc>http://www.example.com/foo.html</loc>
	<lastmod>YYYY-MM-DDThh:mmTZD</lastmod>
	<changefreq>always|hourly|daily|weekly|monthly|yearly|never</changefreq>
</url>

<?php
/** Brewers **/
echo $sitemap->url("/brewers.json");
foreach ($brewers as $item) {
	echo $sitemap->url("/brewers/{$item['Brewers']['id']}.json");
	echo $sitemap->url("/brewers/{$item['Brewers']['id']}/brands.json");
}


/** Brands **/
echo $sitemap->url("/brands.json");
echo $sitemap->url("/brands/top10.json");
foreach ($brands as $item) {
	echo $sitemap->url("/brands/{$item['Brands']['id']}.json");
	echo $sitemap->url("/brands/{$item['Brands']['id']}/prices.json");

	/*foreach ($packages as $package) {
		echo $sitemap->url("/brands/{$item['Brands']['id']}/packages/{$package['Packages']['id']}/prices.json");
	}*/
}

/** Packages **/
echo $sitemap->url("/packages.json");
echo $sitemap->url("/packages/common.json");
foreach ($packages as $item) {
	echo $sitemap->url("/packages/{$item['Packages']['id']}/prices.json");
}

/** Types **/
echo $sitemap->url("/types.json");
foreach ($types as $item) {
	echo $sitemap->url("/types/{$item['Types']['id']}/brands.json");
}
?>
</urlset>
