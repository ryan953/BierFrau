<div id="types_index">
	<div class="toolbar">
		<h1>Beer Types</h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
	</div>
	<ul class="edgetoedge">
	<?php
	foreach($types as $item) {
		$name = $item['Type']['name'] ? $item['Type']['name'] : 'Other';
		$brand_count = count($item['Brand']);
		if ($brand_count > 0) {
			echo "<li>
				<a href='#brands_view' data-url='{$item['Type']['url']}.jqt'>{$name}</a>
				<small class='counter'>{$brand_count}</small>
			</li>\n";
		}
	}
	?>
	</ul>
</div>
