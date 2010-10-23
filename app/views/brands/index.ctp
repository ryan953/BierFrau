<div class="container_12">
	<div class="grid_12">
	filter: brands, prices, packages,
		types, years, imports,
		ratings, price-per-litre

		<ul class="">
		<?php foreach($brands as $brand) { ?>
			<li class="section brand left">
				<ul class="stats row">
					<li class="brand_name"><?php echo $brand['Brand']['name'] ?></li>
					<li class="brand_percent"><?php echo $brand['Brand']['percent'] ?>%</li>
					<li class="brand_year">200<?php echo $brand['Brand']['year'] ?></li>
					<li class="type_name"><?php echo $brand['Type']['name'] ?></li>
				</ul>
				<ul class="stats row">
					<li class="brewer_name"><?php echo $brand['Brewer']['name'] ?></li>
					<li class="brewer_imported"><?php echo $brand['Brewer']['imported'] ? 'import' : 'non-import' ?></li>
				</ul>
				<div class="clearfix"></div>
				<div class="prices">
					<table class="datagrid">
						<tr>
							<th>Package</th>
							<th>Price</th>
							<th>PPL</th>
						</tr>
						<?php foreach ($brand['Price'] as $price) { ?>
							<tr>
								<td><?php echo $price['package_id']; ?></td>
								<td><?php echo $price['amount']; ?></td>
								<td>$0/L</td>
							</tr>
						<?php } ?>
					</table>
				</div>
				<div class="community">
					rating
					view/add comments

				</div>
			</li>
		<?php } ?>
		</ul>

	</div><!-- end .grid_12 -->
</div><!-- end .container_12 -->