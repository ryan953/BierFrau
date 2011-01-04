$(document).bind("mobileinit", function(){
	console.debug('mobileinit');
});

$('div').live('pagebeforecreate', function(event, ui) {
	console.debug('pagebeforecreate', event, ui);
});

$('div').live('pagebeforeshow', function(event, ui) {
	console.debug('pagebeforeshow', event, ui);
});

$(window).bind('hashchange', function(e) {
	console.debug('hashchange', this, e);
	var to = location.hash;
	if (to) {
		$('body').append(
			$('<div>').attr('data-role', 'page').attr('id', to)
		);
	}
});


$.ajax({
	ajaxComplete : function(data){
		console.debug(this, data);

	}
});

$(document).ready(function() {
	var store = getStore();

	$('a[href$=.json]').click(function() {
		$.mobile.pageLoading();
		$.ajax({
			url:$(this).attr('href'),
			type:'GET',
			dataType:'json',
			success: function(data) {

				var tmpl = '#'+data.controller+'_'+data.action+'_tmpl',
					page_id = this.url,
					html = $(tmpl).tmpl(data.response).appendTo('body');
				html.attr('id', page_id);
				$.mobile.changePage(page_id, 'slide', false, true);
				$.mobile.pageLoading(true);
			}
		});
		return false;
	});


});
