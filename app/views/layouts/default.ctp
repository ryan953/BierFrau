<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<title>Beer Price Calculator</title>

	<?php echo $html->css('common'); ?>

	<script type="text/javascript">
		var _webDirectory = '<?php echo Dispatcher::baseUrl() ?>';
	</script>
</head>
<body>
<div id="leftNav" class="ll_navigation">
	<div class="page_section">
		<?php echo $this->element('nav'); ?>
	</div>
</div>
<div id="bodyContent" class="ll_contentlist">
	<?php echo $content_for_layout; ?>
</div>




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<?php echo $scripts_for_layout; ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17878465-1']);
  _gaq.push(['_setDomainName', '.bierfrau.com']);
  _gaq.push(['_trackPageview']);

  (function() {
	 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>