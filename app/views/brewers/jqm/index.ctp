<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Brewers</h1>
		<a href="/" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-filter="true">
			<?php
			$last_letter = '0-9';
			foreach($brewers as $item) {
				if ($last_letter != substr($item['Brewer']['name'], 0, 1)) {
					$last_letter = substr($item['Brewer']['name'], 0, 1);
					echo "<li data=role='list-divider'>{$last_letter}</li>\n";
				}
				echo "<li><a href='{$item['Brewer']['url']}.jqm'>{$item['Brewer']['name']}</a></li>\n";
			}
			?>
		</ul>
	</div>
</div>
