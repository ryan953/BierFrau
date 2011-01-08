<?php
Configure::write('debug', 0);
header('Pragma: no-cache');
header('Cache-Controle: no-store, no-cache, max-age=0, must-revalidate');

//$this->header("X-JSON: {$content_for_layout}"); //there is a limit tot he amount of data allowed in a header
echo $content_for_layout;
?>
