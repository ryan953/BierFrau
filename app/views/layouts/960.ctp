<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Beer Price Calculator</title>

	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<?php echo $html->css('978'); ?>
	<?php echo $html->css('main'); ?>

	<script type="text/javascript">
		var _webDirectory = '<?php echo Dispatcher::baseUrl() ?>';
	</script>
</head>
<body class="browser">


<?php echo $content_for_layout; ?>


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