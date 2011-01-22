<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Top 10 Brands</h1>
		<a href="/" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ol data-role="listview">
			<?php
			foreach($brands as $item) {
				echo "<li><a href='{$item['Brand']['url']}.jqm'>{$item['Brand']['name']}</a></li>\n";
			}
			?>
		</ol>
	</div>
</div>
