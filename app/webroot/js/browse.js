var items = {
	getBrands: function() {
		$.ajax({
			url:_webDirectory + '/brands/index.json', 
			dataType: 'json', 
			success:function(data) {
				$('#console pre').html( $('#console').html()+JSON.stringify(data.brands, null, 3) )
				
				var items = data.brands.map(function(item) {
					return "<option value='" + item.Brand.id + "'>" + item.Brand.name + "</option>";
				}).reduce(function(prev, cur) {
					return prev + cur;
				});
				$('#brand_name').replaceWith(
					"<select id='brand_name'>" + items + "</select>"
				);
			}
		});
	}
};

var calc = {

};

jQuery(document).ready(function($) {
	
});



if (!Array.prototype.map)
{
  Array.prototype.map = function(fun /*, thisp*/)
  {
    var len = this.length >>> 0;
    if (typeof fun != "function")
      throw new TypeError();

    var res = new Array(len);
    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        res[i] = fun.call(thisp, this[i], i, this);
    }

    return res;
  };
}

if (!Array.prototype.reduce)  
{  
  Array.prototype.reduce = function(fun /*, initial*/)  
  {  
    var len = this.length >>> 0;  
    if (typeof fun != "function")  
      throw new TypeError();  
  
    // no value to return if no initial value and an empty array  
    if (len == 0 && arguments.length == 1)  
      throw new TypeError();  
  
    var i = 0;  
    if (arguments.length >= 2)  
    {  
      var rv = arguments[1];  
    }  
    else  
    {  
      do  
      {  
        if (i in this)  
        {  
          var rv = this[i++];  
          break;  
        }  
  
        // if array contains no values, no initial value to return  
        if (++i >= len)  
          throw new TypeError();  
      }  
      while (true);  
    }  
  
    for (; i < len; i++)  
    {  
      if (i in this)  
        rv = fun.call(null, rv, this[i], i, this);  
    }  
  
    return rv;  
  };  
}  