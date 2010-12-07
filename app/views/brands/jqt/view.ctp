<div id="brands_view_<?php echo $brand['Brand']['id'] ?>">
	<div class="toolbar">
		<h1><?php echo $brand['Brand']['name'] ?></h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
	</div>
	<ul class="rounded">
		<li>
			<span class="name">Name</span>
			<span class="val"><?php echo $brand['Brand']['name'] ?></span>
		</li>
		<li class="arrow">
			<span class="name">Type</span>
			<span class="val"><?php echo $brand['Type']['name'] ?></span>
		</li>
		<li class="arrow">
			<a href="#brewers_view" data-url="<?php echo $brand['Brewer']['url'] ?>.jqt">Brewer
				<span class="val"><?php echo $brand['Brewer']['name'] ?></span>
			</a>
			<?php if (!$brand['Brewer']['imported']) { /*echo "<small>import</small>";*/ } ?>
		</li>
		<li>
			<span class="name">Percent</span>
			<span class="val"><?php echo $brand['Brand']['percent'] ?>%</span>
		</li>
		<?php if ($brand['Brand']['year']) { ?>
			<li>
				<span class="name">Year</span>
				<span class="val"><?php echo $brand['Brand']['year'] ?></span>
			</li>
		<?php } ?>
	</ul>

	<h2>Prices</h2>
	<ul class="rounded">
		<?php foreach($brand['Price'] as $price) { ?>
			<li>
				<span class="name"><?php echo $price['Package']['name'] ?></span>
				<span class="val">$<?php echo number_format($price['price_per_litre'], 2) ?>/litre</span>
				<small class="counter">$<?php echo number_format($price['amount'], 2) ?></small>
			</li>
		<?php } ?>

		<!-- ['Price'][0-n]['Package']['quantity'] -->
		<!-- ['Price'][0-n]['Package']['Container']['name'] -->
		<!-- ['Price'][0-n]['Package']['Container']['volume_unit'] -->
		<!-- ['Price'][0-n]['Package']['Container']['volume_amount'] -->
		<!-- ['Price'][0-n]['Package']['Container']['return'] -->
		<!-- ['Price'][0-n]['Location']['name']-->
		<!-- ['Price'][0-n]['timestamp'] -->
	</ul>

	<div class="info">
		<p>
		Most containers over 630mL carry a $0.20 deposit;<br/>
		those under 630mL carry a $0.10 deposit;<br/>
		aluminum and steel cans over 1L carry a $0.20 deposit;<br/>
		those 1L and under carry a $0.10 deposit.
		<!--
		http://www.bagitback.ca/bagitback/en/residential/faq.shtml
		http://www.thebeerstore.ca/storesandproducts-kegs.html
		-->
		</p>
	</div>
</div>
