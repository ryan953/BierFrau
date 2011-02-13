(function() {
	var store_name = 'favorites',
	class_name = 'favorite';
	refresh_favs = function() {
		var favs = getStore().getObj(store_name), arr = [],
			favs_page = $('.favorites_view .ui-listview');
		if (favs_page.length > 0) {
			for (var url in favs) {
				arr.push({ url:url, name:favs[url] });
			}
			favs_page.html( $('#favorite_item_tmpl').tmpl(arr) ).listview('refresh');
		}
	}

	$('div').live('pageshow', function() {
		var current = $('.ui-page-active.brands_view'),
			favs = getStore().getObj(store_name);
		if (current.attr('data-url') in favs) {
			current.addClass(class_name);
		}
	});
	$('.favorite-brand').live('tap click', function() {
		var current = $('.ui-page-active.brands_view').addClass(class_name),
			favs = getStore().getObj(store_name),
			url = current.attr('data-url');
		if (!(url in favs)) {
			favs[url] = $('h2', current).first().html();
			getStore().put(store_name, favs);
			refresh_favs();
		}
	});
	$('.unfavorite-brand').live('tap click', function() {
		var url = $('.ui-page-active.brands_view').removeClass(class_name).attr('data-url'),
			favs = getStore().getObj(store_name);
		if ((url in favs)) {
			delete favs[url];
			getStore().put(store_name, favs);
			refresh_favs();
		}
	});

	$(getStore()).bind('favorites.change', refresh_favs);

	$('div').live('pageshow', function() {
		if ($('.ui-page-active').hasClass('favorites_view')) {
			refresh_favs();
		}
	});
})(jQuery);
