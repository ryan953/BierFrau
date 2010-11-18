<div>
	<div class="toolbar">
		<h1><?php echo $brewer['Brewer']['name'] ?></h1>
		<a class="back" href="#">Back</a>
	</div>
	<ul class="rounded">
		<li>
			<span class="name">Name</span>
			<span class="val"><?php echo $brewer['Brewer']['name'] ?></span>
			<?php if (!$brewer['Brewer']['imported']) { /*echo "<small>import</small>";*/ } ?>
		</li>
	</ul>

	<h2>Brands</h2>
	<ul class="rounded">
		<?php foreach($brewer['Brand'] as $brand) { ?>
			<li>
				<small><?php echo $brand['percent'] ?>%</small>
				<a href="<?php echo $brand['url'] ?>.jqt">
					<span class="name"><?php echo $brand['name'] ?></span>
				</a>
				<span class="val"><?php echo $brand['Type']['name'] ?></span>
			</li>
		<?php } ?>
	</ul>
</div>
