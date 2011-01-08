<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Price Ranges ($ per litre)</h1>
		<a href="#home" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview">
			<?php
			foreach($prices as $item) {
				$range_start = number_format($item['PriceRanges']['price_range'], 2);
				$range_end = number_format($item['PriceRanges']['price_range']+1, 2);
				echo "<li><a href='/prices/ranges/{$item['PriceRanges']['price_range']}.jqm'>\${$range_start} to \${$range_end}</a>
				<span class='ui-li-count'>{$item[0]['count']}</span></li>\n";
			}
			?>
		</ul>
	</div>
</div>
