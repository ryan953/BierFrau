<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1><?php echo $brand['Brand']['name'] ?></h1>
		<a href="/" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li>
				<h5 class="value"><?php echo $brand['Brand']['name'] ?></h5>
				<p class="label">Name</p>
			</li>
			<li>
				<a href="<?php echo $brand['Brewer']['url'] ?>.jqm">
					<h5 class="value"><?php echo $brand['Brewer']['name'] ?></h5>
					<p class="label">Brewer</p>
				</a>
				<?php if (!$brand['Brewer']['imported']) { /*echo "<span class='.ui-li-aside'>import</span>";*/ } ?>
			</li>
			<li>
				<a href="/brands/type/<?php echo $brand['Type']['id'] ?>.jqm">
					<h5 class="value"><?php echo $brand['Type']['name'] ?></h5>
					<p class="label">Type</p>
				</a>
			</li>
			<li>
				<h5 class="value"><?php echo $brand['Brand']['percent'] ?>%</h5>
				<p class="label">Percent</p>
			</li>
			<?php if ($brand['Brand']['year']) { ?>
				<li>
					<h5 class="value"><?php echo $brand['Brand']['year'] ?></h5>
					<p class="label">Year</p>
				</li>
			<?php } ?>
		</ul>

		<h2>Prices</h2>
		<ul data-role="listview" data-inset="true">
			<?php foreach($brand['Currentprice'] as $price) { ?>
				<li>
					<span class="ui-li-count">$<?php echo number_format($price['price_per_litre'], 2) ?> / L</span>
					<h5><?php echo $price['Package']['name'] ?></h5>
					<p>$<?php echo number_format($price['amount'], 2) ?></p>
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
	</div>
	<div data-role="footer" data-theme="a" class="ui-bar">
		<p>
			<small>
			Most containers over 630mL carry a $0.20 deposit;<br/>
			those under 630mL carry a $0.10 deposit;<br/>
			aluminum and steel cans over 1L carry a $0.20 deposit;<br/>
			those 1L and under carry a $0.10 deposit.
			<!--
			http://www.bagitback.ca/bagitback/en/residential/faq.shtml
			http://www.thebeerstore.ca/storesandproducts-kegs.html
			-->
			</small>
		</p>
	</div>
</div>
