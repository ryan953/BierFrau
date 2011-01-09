<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>$<?php echo number_format($range, 2) ?> to $<?php echo number_format($range+1, 2) ?> per litre</h1>
		<a href="#home" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-filter="true">
			<?php
			foreach($prices as $item) {
				$ppl = number_format($item['PriceRanges']['price_per_litre'], 2);
				$price = number_format($item['PriceRanges']['amount'], 2);
				echo "<li>";
					echo "<h3><a href='{$item['Brand']['url']}.jqm'>{$item['Brand']['name']}</a></h3>";
					echo "<p>\${$price} for {$item['PriceRanges']['quantity']} {$item['PriceRanges']['container_name']}</p>";
					echo "<span class='ui-li-count'>\${$ppl} / litre</span>";
				echo "</li>\n";
			}
			?>
		</ul>
	</div>
</div>
