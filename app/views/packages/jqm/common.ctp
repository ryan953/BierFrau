<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Common Packages</h1>
		<a href="#home" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview">
		<?php
		foreach($packages as $item) {
			$name = $item['Package']['name'] ? $item['Package']['name'] : 'Other';
			$brand_count = count($item['Price']);
			if ($brand_count > 0) {
				echo "<li>
					<span class='ui-li-count'>{$brand_count}</span>
					<a href='{$item['Package']['url']}.jqm'>{$name}</a>
				</li>\n";
			}
		}
		?>
		</ul>
	</div>
</div>
