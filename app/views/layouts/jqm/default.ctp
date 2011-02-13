<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title><?php echo $title_for_layout ?> - Bierfrau.com</title>

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.css" />
		<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>

		<script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>

		<link href="/css/mobile_jqm.css" rel="stylesheet" type="text/css">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />

		<!--
		114 for retna display
		72 on ipad
		57 on iphone
		-->
		<link rel="apple-touch-icon-precomposed" href="/img/bierfrau_appicon.png"/>
		<link rel="apple-touch-startup-image" href="/img/bierfrau_sketch.png"/>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-20543735-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>
	<body>

		<?php echo $content_for_layout; ?>

		<script src="/js/jquery.store.js" type="text/javascript"></script>
		<script src="/js/mobile_jqm.js" type="text/javascript"></script>

		<script src="/js/favorites.js" type="text/javascript"></script>
		<?php echo $scripts_for_layout; ?>
	</body>
</html>
