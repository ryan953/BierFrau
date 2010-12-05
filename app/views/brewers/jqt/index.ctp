<div id="brewers_index">
	<div class="toolbar">
		<h1>Brewers</h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
	</div>
	<ul class="edgetoedge">
	<?php
	$last_letter = '0-9';
	foreach($brewers as $item) {
		if ($last_letter != substr($item['Brewer']['name'], 0, 1)) {
			$last_letter = substr($item['Brewer']['name'], 0, 1);
			echo "<li class='sep'>{$last_letter}</li>\n";
		}
		echo "<li><a href='#brewers_view' data-url='{$item['Brewer']['url']}.jqt'>{$item['Brewer']['name']}</a></li>\n";
	}
	?>
	</ul>
</div>
