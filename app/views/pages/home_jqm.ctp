<div data-role="page" data-theme="b" id="home">
	<div data-role="header" data-back="false">
		<h1>BierFrau.com</h1>
		<a href="#about" class="ui-btn-right" data-rel="dialog" data-transition="pop" data-icon="info">About</a>
	</div><!-- /header -->

	<div data-role="content">
		<h2>Browse Beers</h2>
		<ul data-role="listview" data-inset="true">
			<li><a href="/brands/top10.jqm">Top 10 Brands</a></li>
			<li><a href="/brands/random.jqm">Random Brand</a></li>
			<!--
			<li><a href="/brands/onsale.jqm">On Sale Now</a></li>
			-->
		</ul>
		<ul data-role="listview" data-inset="true">
			<!--
			<li><a href="/prices/ranges.json">Price Ranges</a></li>
			-->
			<li><a href="/types.jqm">Beer Types</a></li>
			<li><a href="/packages/common.jqm">Common Packages</a></li>
			<!--
			<li><a href="/locations.jqm">Country Of Origin</a></li>
			-->
		</ul>
		<ul data-role="listview" data-inset="true">
			<li><a href="/brewers.jqm">All Brewers</a></li>

			<!--
			<li><a href="/brands/beer_store.jqm">Beer Store Brands</a></li>
			<li><a href="/brands/lcbo.jqm">LCBO Brands</a></li>
			-->

			<li><a href="/brands.jqm">All Brand Names</a></li>
		</ul>
	</div><!-- /content -->

</div><!-- /page -->

<div data-role="page" data-theme="b" id="about">
	<div data-role="content">
		<h2>BierFrau.com</h2>
		<p>
			BierFrau is a price calculator designed to help you get the most beer
			for your buck. You can compare the cost per litre for various size
			cans and bottles, and get best possible value by being smart about which packaging you choose.
		</p>
		<p>
			The site is developed and maintained
			by <a href="http://ryanalbrecht.ca">Ryan Albrecht</a>, a nice German guy,
			and <a href="http://noxdineen.com">Nox Dineen</a>, a bonny Irish lass.
			As you can imagine, a pair like that quickly discovered the value
			in efficiently purchasing large quantities of beer. The BeerFrau girl was
			expertly sketched by <a href="http://www.steveschoger.com/">Steve Schoger</a>.
		</p>
		<p>
			Currently the site contains price data for Ontario's
			<a href="http://thebeerstore.ca">Beer Store</a>, updated weekly. We’ll be
			adding more vendors and locations sometime.
		</p>

		<div class="ui-grid-a">
			<div class="ui-block-a">
				<a href="mailto:ryan@bierfrau.com" data-role="button" data-theme="b">Email Us</a>
			</div>
			<!--<div class="ui-block-b">
				<a href="#home" data-role="button" class="clearcache">Clear Cache</a>
			</div>
			-->
			<div class="ui-block-b">
				<a href="#api" data-role="button">API</a>
			</div>
		</div><!-- /grid-a -->

		<a href="#home" data-role="button" data-transition="pop" data-theme="a" data-icon="delete" data-iconpos="right">Close</a>

	</div><!-- end @page -->
</div>


<div data-role="page" data-theme="a" id="api">
	<div data-role="header" data-nobackbtn="true">
		<h1>API</h1>
		<a href="#about" class="ui-btn-right" data-transition="pop" data-icon="home">Home</a>
	</div><!-- /header -->
	<div data-role="content">
		<p>
			Any of the following url's can be queryied with an optional <code><span>callback</span></code> query string parameter for use with jsonp and ajax.
		</p>
		<ul data-role="listview" data-theme="c" data-dividertheme="d" class="api-route-list">
			<?php
			$groups = array(
				'Brewers'=>array(
					'/brewers.json',
					'/brewers/<span>id</span>.json',
				),
				'Brands'=>array(
					'/brands.json',
					'/brands/top10.json',
					'/brands/random.json',
					'/brands/<span>id</span>.json',

					'/brands/type/<span>type_id</span>.json',
					'/brands/package/<span>package_id</span>.json',
				),
				'Prices'=>array(
					'/prices.json',
					'/prices/view/<span>id</span>.json',
				),
				'Packages'=>array(
					'/packages.json',
					'/packages/common.json',
				),
				'Other'=>array(
					'/containers.json',
					'/locations.json',
					'/types.json',
				)
			);
			foreach ($groups as $group=>$routes) {
				echo "<li data-role='list-divider'>$group</li>";
				foreach ($routes as $route) {
					echo "<li><code>$route</code></li>";
				}
			}
			?>
		</ul>

	</div><!-- end @page -->
</div>
