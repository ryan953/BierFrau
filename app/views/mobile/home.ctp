<div id="home" class="current">
	<div class="toolbar">
		<h1>BierFrau.com</h1>
		<a class="button slideup" id="infoButton" href="#about">About</a>
	</div>

	<h2>Browse Beers</h2>
	<ul class="rounded">
		<!--<li class="arrow"><a href="/brewers">Brewers</a> <small class="counter">4</small></li>-->

		<li class="arrow"><a href="/brands.jqt">Brand Names</a></li>
		<li class="arrow"><a href="/brewers.jqt">Brewers</a></li>

		<!--<li class="arrow"><a href="/brands/view/4.jqt">Antigravity</a></li>-->

		<!--<li class="arrow"><a href="/types.jqt">Beer Types</a></li>
		<li class="arrow"><a href="/locations.jqt">Location</a></li>
		<li class="arrow"><a href="/packages/common.jqt">Common Packages</a></li>

		<li class="arrow"><a href="/prices/ranges.json">Price Ranges</a></li>-->
	</ul>
</div>

<div id="brewers_view"></div>
<div id="brands_view"></div>

<div id="about" class="selectable">
	<!--<p><img src="jqtouch.png" /></p>-->
	<p>
		<strong>Bierfrau.com</strong>
	</p>

	<p>
		BierFrau is a price calculator designed to help you get the most beer
		for your buck. You can compare the cost per litre for various size
		cans and bottles, and get best possible value by being smart about which packaging you choose.
	</p>
	<p>
		The site is developed and maintained
		by <a href="//ryanalbrecht.ca">Ryan Albrecht</a>, a nice German (heritage) guy,
		and <a href="//noxdineen.com">Nox Dineen</a>, a bonny Irish (heritage) lass.
		As you can imagine, a pair like that quickly discovered the value
		in efficiently purchasing large quantities of beer.
	</p>
	<p>
		Currently the site contains price data for Ontario’s
		<a href="//thebeerstore.ca">Beer Store</a>, updated weekly. We’ll be
		adding more vendors and locations sometime.
	</p>

	<p>
		bierfrau.com is made possible with the wonderful <a href="http://www.jqtouch.com/" target="_blank">jQTouch</a>
	</p>
	<p><br /><br /><a href="#" class="grayButton goback">Close</a></p>
</div>






















<script type="text/html" id="brewer_view_tmpl">
<div id="brewers_view_{Brewer.id}">
		<div class="toolbar">
			<h1>{Brewer.name}</h1>
			<a class="back" href="#">Back</a>
		</div>
		<ul class="rounded">
			<li>
				<span class="name">Name</span>
				<span class="val">{Brewer.name}</span>
				<!--<small>{Brewer.imported}</small>-->
			</li>
		</ul>

		<h2>Brands</h2>
		<ul class="rounded">
			{list_brands}
		</ul>
	</div>
</script>

<script type="text/html" id="brewer_view_brands_tmpl">
	<li class="arrow">
		<small>{percent}%</small>
		<a href="/brands/view/{id}.json">{name}
			<span class="val">{Type.name}</span>
		</a>
	</li>
</script>
