<div id="brewers_view_<?php echo $brewer['Brewer']['id'] ?>">
	<div class="toolbar">
		<h1><?php echo $brewer['Brewer']['name'] ?></h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
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
			<li class="arrow">

				<a href="#brands_view" data-url="/brands/view/<?php echo $brand['id'] ?>.jqt"><?php echo $brand['name'] ?>
					<span class="val"><?php echo $brand['Type']['name'] ?></span>
				</a>
				<small class="counter"><?php echo $brand['percent'] ?>%</small>
			</li>
		<?php } ?>
	</ul>
</div>
