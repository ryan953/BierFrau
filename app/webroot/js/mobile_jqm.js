$('div').live('pageshow',function(event, ui){
	_gaq.push(['_trackPageview', $(this).attr('id')]);
});
