<div>
	<div class="toolbar">
		<h1>Brewers</h1>
		<a class="back" href="#">Home</a>
	</div>
	<ul class="edgetoedge">
	<?php
	$last_letter = '0-9';
	foreach($brewers as $item) {
		if ($last_letter != substr($item['Brewer']['name'], 0, 1)) {
			$last_letter = substr($item['Brewer']['name'], 0, 1);
			echo "<li class='sep'>{$last_letter}</li>\n";
		}
		echo "<li><a href='{$item['Brewer']['url']}.jqt'>{$item['Brewer']['name']}</a></li>\n";
	}
	?>
	</ul>
</div>
