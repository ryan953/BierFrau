<div data-role="page" data-theme="b">
	<div data-role="header">
		<h1>Brand Names</h1>
		<a href="#home" data-role="button" data-icon="home" class="ui-btn-right">Home</a>
	</div>
	<div data-role="content">
		<ol data-role="listview" data-filter="true">
			<?php
			$last_letter = '0-9';
			foreach($brands as $item) {
				if ($last_letter != substr($item['Brand']['name'], 0, 1)) {
					$last_letter = substr($item['Brand']['name'], 0, 1);
					$last_letter = (is_numeric($last_letter) ? "#" : $last_letter);
					echo "<li data=role='list-divider'>{$last_letter}</li>\n";
				}
				echo "<li><a href='{$item['Brand']['url']}.jqm'>{$item['Brand']['name']}</a></li>\n";
			}
			?>
		</ol>
	</div>
</div>
