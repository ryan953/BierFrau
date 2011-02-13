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
			/*console.debug("Trigger:", key + '.' + action, {
				oldVal:oldVal,
				newVal:newVal
			});*/
			$(this).trigger(key + '.' + action, {
				oldVal:oldVal,
				newVal:newVal
			});
		}
	}

	getStore = function() {
		return supports_html5_storage() ? new LocalStore() : new JSStore();
	}

	var LocalStore = function() {};
	LocalStore.prototype = new Store();
	LocalStore.prototype.get = function(key) {
		return JSON.parse(localStorage.getItem(key)) || null;
	}
	LocalStore.prototype.getArr = function(key) {
		return JSON.parse(localStorage.getItem(key)) || [];
	}
	LocalStore.prototype.getObj = function(key) {
		return JSON.parse(localStorage.getItem(key)) || {};
	}
	LocalStore.prototype.put = function(key, val) {
		var oldVal = this.get(key);
		//if (!isEqual.call(oldVal, val)) {
			localStorage.setItem(key, JSON.stringify(val));
			(oldVal ? this.fire(key, 'change', oldVal, val) : this.fire(key, 'add', null, val));
		//}
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
})();

isEqual = function(x) {
	for(p in this) {
		if(typeof(x[p])=='undefined') {return false;}
	}
	for(p in this) {
		if (this[p]) {
			switch(typeof(this[p])) {
			case 'object':
				if (!this[p].equals(x[p])) { return false }; break;
			case 'function':
				if (typeof(x[p])=='undefined' || (p != 'equals' && this[p].toString() != x[p].toString())) { return false; }; break;
			default:
				if (this[p] != x[p]) { return false; }
			}
		} else {
			if (x[p]) {
				return false;
			}
		}
	}
	for(p in x) {
		if(typeof(this[p])=='undefined') {return false;}
	}
	return true;
}
