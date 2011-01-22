<?php
/* /app/views/helpers/link.php */

class SitemapHelper extends AppHelper {

	function url($loc = null, $lastMod = null, $changeFreq = null) {
		$items = array(
			(!empty($loc) ? "<loc>http://bierfrau.com{$loc}</loc>" : ''),
			(!empty($lastMod) ? "<lastmod>{$lastMod}</lastmod>" : ''),
			(!empty($changeFreq) && $this->changeFreq($changeFreq) ? "<changeFreq>{$changeFreq}</changeFreq>" : '')
		);
		return $this->output("<url>" . implode('', $items) . "</url>\n");
	}

	private function changeFreq($freq) {
		return in_array($freq, array(	'always','hourly','daily','weekly','monthly','yearly','never'));
	}
}

?>
