<div id="brands_top10">
	<div class="toolbar">
		<h1>Top 10 Brands</h1>
		<a class="back" href="#">Back</a>
		<a class="button" href="#home">Home</a>
	</div>
	<ul class="edgetoedge">
	<?php
	foreach($brands as $item) {
		echo "<li><a href='#brands_view' data-url='{$item['Brand']['url']}.jqt'>{$item['Brand']['name']}</a></li>\n";
	}
	?>
	</ul>
</div>
