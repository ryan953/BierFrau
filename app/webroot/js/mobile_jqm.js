$('div').live('pageshow',function(event, ui){
	_gaq.push(['_trackPageview', $(this).attr('id')]);
});


$(document).ready(function() {
	store = getStore();
	/*$('#jqt').jqtload(store)
		.delegate('.clearcache', 'tap', function() {
			console.debug('clear cache');
			store.clear();
		});
	*/
});


function oc(a) {
	var o = {};
	for(var i=0;i<a.length;i++) {
		o[a[i]]='';
	}
	return o;
}
