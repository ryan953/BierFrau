Template = {
	_cache: {},
	get: function(selector) {
		if (!Template._cache[selector]) {
			Template._cache[selector] = $(selector).html().replace('<!--<![CDATA[', '').replace(']]>-->', '');
		}
		return Template._cache[selector];
	},
	replace: function(template, params, prefix) {
		prefix = (prefix ? prefix + '.' : '');
		var param, obj_type;
		for(param in params) {
			obj_type = typeof(params[param]);
			if (params[param] !== null
				&& params[param] !== undefined
				&& ((obj_type != 'object' && template.indexOf("{" + prefix + param + "}") >= 0) || obj_type == 'object')
			) {
				if (obj_type == 'object') {
					template = Template.replace(template, params[param], prefix + param);
				} else if (obj_type == 'function') {
					template = template.split("{" + prefix + param +"}").join(params[param]());
				} else {
					template = template.split("{" + prefix + param +"}").join(params[param]);
				}
			}
		}
		return template;
	}
};

(function($){
	$.fn.jqtload = function(store) {
		return this.delegate('a[data-url]', 'tap', function(e) {
			var id = $(this).attr('href'),
				url = $(this).attr('data-url');
			if ( store.get(url) ) {
				$(id).html( store.get(url) );
			} else {
				$.ajax({
					url:url,
					success:function(data) {
						store.put(url, data);
						$(id).html( store.get(url) );
					}
				});
			}
		});
	};
}(jQuery));


(function(){
	function supports_html5_storage() {
		try {
			return 'localStorage' in window && window["localStorage"] !== null;
		} catch (e) {
			return false;
		}
	}
	function Store() {
		this.appendTo = function(key, val) {
			var arr = (this.get(key) || []);
			arr.push(val);
			this.put(key, arr);
		}
		this.fire = function(key, action, oldVal, newVal) {
			console.debug("Trigger:", key + '.' + action, {
				oldVal:oldVal,
				newVal:newVal
			});
			$(this).trigger(key + '.' + action, {
				oldVal:oldVal,
				newVal:newVal
			});
		}
		function get() {
			return 1;
		}
	}

	getStore = function() {
		return supports_html5_storage() ? new LocalStore() : new JSStore();
	}

	var LocalStore = function() {};
	LocalStore.prototype = new Store();
	LocalStore.prototype.get = function(key) {
		return JSON.parse(localStorage.getItem(key));
	}
	LocalStore.prototype.put = function(key, val) {
		var oldVal = this.get(key);
		localStorage.setItem(key, JSON.stringify(val));
		(oldVal ? this.fire(key, 'change', oldVal, val) : this.fire(key, 'add', null, val));
	}
	LocalStore.prototype.remove = function(key) {
		var oldVal = this.get(key);
		localStorage.removeItem(key);
		this.fire(key, 'remove', oldVal, null);
	}
	LocalStore.prototype.clear = function() {
		localStorage.clear();
		this.fire('*', 'clear', null, null);
	}

	var JSStore = function() {};
	JSStore.prototype = new Store();
	JSStore.prototype.data = {};
	JSStore.prototype.get = function(key) {
		return this.data[key] || null;
	}
	JSStore.prototype.put = function(key, val) {
		var oldVal = this.get(key);
		this.data[key] = val;
		(oldVal ? this.fire(key, 'change', oldVal, val) : this.fire(key, 'add', null, val));
	}
	JSStore.prototype.remove = function(key) {
		var oldVal = this.get(key);
		unset(this.data[key]);
		this.fire(key, 'remove', oldVal, null);
	}
	JSStore.prototype.clear = function() {
		this.data = {};
		this.fire('*', 'clear', null, null);
	}
})();


$(document).ready(function() {
	var store = getStore();
	$('#jqt').jqtload(store);

});
