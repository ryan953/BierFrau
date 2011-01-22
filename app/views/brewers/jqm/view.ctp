<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1><?php echo $brewer['Brewer']['name'] ?></h1>
		<a href="/" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li>
				<h3><?php echo $brewer['Brewer']['name'] ?></h3>
				<p>Name</p>
				<?php if (!$brewer['Brewer']['imported']) { /*echo "<span class='ui-li-count'>import</span>";*/ } ?>
			</li>
			<li>
				<h3><?php echo (isset($brewer['Brewer']['year']) ? $brewer['Brewer']['year'] : '?') ?></h3>
				<p>Year</p>
				<?php if (!$brewer['Brewer']['imported']) { /*echo "<span class='ui-li-count'>import</span>";*/ } ?>
			</li>
		</ul>

		<h2>Brands</h2>
		<ul data-role="listview" data-inset="true">
			<?php foreach($brewer['Brand'] as $brand) { ?>
				<li>
					<a href="/brands/view/<?php echo $brand['id'] ?>.jqm">
						<h5><?php echo $brand['name'] ?></h5>
						<p><?php echo $brand['Type']['name'] ?></p>
						<span class='ui-li-count'><?php echo $brand['percent'] ?>%</span>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
