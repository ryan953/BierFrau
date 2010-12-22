<?php
Configure::write('debug', 0);
header('Pragma: no-cache');
header('Cache-Controle: no-store, no-cache, max-age=0, must-revalidate');
header('Content-Type: text/cache-manifest');
//AddType  .manifest

echo $content_for_layout;
?>
