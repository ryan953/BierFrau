<div id="brands_index">
	<div class="toolbar">
		<h1>Brand Names</h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
	</div>
	<ul class="edgetoedge">
	<?php
	$last_letter = '0-9';
	foreach($brands as $item) {
		if ($last_letter != substr($item['Brand']['name'], 0, 1)) {
			$last_letter = substr($item['Brand']['name'], 0, 1);
			echo "<li class='sep'>{$last_letter}</li>\n";
		}
		echo "<li><a href='#brands_view' data-url='{$item['Brand']['url']}.jqt'>{$item['Brand']['name']}</a></li>\n";
	}
	?>
	</ul>
</div>
