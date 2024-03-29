<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Beer Types</h1>
		<a href="/" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview">
		<?php
		foreach($types as $item) {
			$name = $item['Type']['name'] ? $item['Type']['name'] : 'Other';
			$brand_count = isset($item['Brand']) ? count($item['Brand']) : 0;
			if ($brand_count > 0) {
				echo "<li>
					<span class='ui-li-count'>{$brand_count}</span>
					<a href='{$item['Type']['url']}.jqm'>{$name}</a>
				</li>\n";
			} else {
				echo "<li>
						<a href='{$item['Type']['url']}.jqm'>{$name}</a>
					</li>\n";
			}
		}
		?>
		</ul>
	</div>
</div>
