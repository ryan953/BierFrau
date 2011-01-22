<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Bierfrau.com - Beer Price Information</title>
		<style type="text/css" media="screen">@import "/jqtouch/jqtouch.css";</style>
		<style type="text/css" media="screen">@import "/jqtouch/themes/jqt/theme.css";</style>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script src="/jqtouch/jqtouch.js" type="application/x-javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			var jQT = new $.jQTouch({
				icon: 'jqtouch.png',
				icon4: 'jqtouch4.png',
				addGlossToIcon: false,
				startupScreen: 'jqt_startup.png',
				statusBar: 'black',
				useFastTouch: false,
				preloadImages: [
					'/jqtouch/themes/jqt/img/back_button.png',
					'/jqtouch/themes/jqt/img/back_button_clicked.png',
					'/jqtouch/themes/jqt/img/button_clicked.png',
					'/jqtouch/themes/jqt/img/grayButton.png',
					'/jqtouch/themes/jqt/img/whiteButton.png',
					'/jqtouch/themes/jqt/img/loading.gif'
				]
			});
		</script>
		<script src="/js/mobile_jqt.js" type="text/javascript"></script>

		<link href="/css/mobile_jqt.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="jqt">

			<?php echo $content_for_layout; ?>

		</div>

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
