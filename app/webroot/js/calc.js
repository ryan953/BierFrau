var Container = {
	getType: function(input) {
		input = input.split(' ');
		for(var i in input) {
			var val = input[i].toUpperCase();
			if (val in Calc.accepted_types) {
				return Calc.getValidType(val);
			}
		}
	},
	getCount: function(input) {
		input = input.split(' ');
		for(var i in input) {
			var val = input[i].toUpperCase();
			if (val == parseInt(val, 10)) {
				return val;
			}
		}
		return 0;
	},
	getSize: function(input) {
		var size = '', match;
		for(unit in Calc.accepted_units) {
			match = input.match(new RegExp('[0-9]+\\s*'+unit, 'i'));
			size = (match ? match[0] : size);
		}
		return {
			vol: parseInt(size, 10),
			unit: Calc.getValidUnit( (size).replace(parseInt(size, 10), '').trim() )
		};
	}
};

var Calc = {
	valid_types: ['unknown', 'Bottle', 'Can', 'Keg'],
	accepted_types: {
		'BOTTLE':1, 'BOTTLES':1, 
		'CAN':2, 'CANS':2, 'TALLBOY':2, 'TALLCAN':2, 'TALLBOYS':2, 'TALLCANS':2, 
		'KEG':3, 'KEGS':3
	},
	getValidType: function(input_type) {
		return Calc.valid_types[
			Calc.accepted_types[input_type.toUpperCase()]
		];
	},
	valid_units: ['unknown', 'ml', 'l'],
	accepted_units: {
		'ML':1, 'MILLILITRE':1, 'MILLILITER':1, 'MILLILITRES':1, 'MILLILITERS':1, 
		'L':2, 'LITRE':2, 'LITER':2, 'LITRES':2, 'LITERS':2
	},
	getValidUnit: function(input_unit) {
		return Calc.valid_units[
			Calc.accepted_units[input_unit.toUpperCase()]
		];
	},
	
	volumeToLiters: function(volume, unit) {
		return (
			unit == 'ml' ? volume / 1000 : 
			unit = 'l' ? volume :
			0
		);
	},
	packageVolumeInLiters: function(coutainer_count, container_volume, container_unit) {
		return coutainer_count * Calc.volumeToLiters(container_volume, container_unit);
	}
};

var Event = {
	input_changed: function() {
		var package_size = $('#package_size'),
			package_qty = $('#package_qty'),
			price = $('#price');
		return function(e) {
			var container = {},
				package = {},
				totals = {};
	
			container = (function(input) {
				return {
					size: Container.getSize(input),
					type: Container.getType(input),
					count: Container.getCount(input)
				};
			})(package_size.val());
			container.vol = Calc.volumeToLiters(container.size.vol, container.size.unit);
			package.vol = Calc.packageVolumeInLiters(container.count, container.size.vol, container.size.unit);
			totals = (function(qty, price) {
				return {
					cost: qty * price.replace('$', ''),
					vol: qty * package.vol
				};
			})(package_qty.val(), price.val());
			totals.price_per_liter = totals.cost / totals.vol;
			
			$("#container_type").html(container.type);
			$("#container_count").html(container.count);
			$("#container_volume").html(container.vol + 'L');
			$("#package_volume").html(package.vol + 'L');
			$("#total_cost").html('$' + totals.cost);
			$("#total_volume").html(totals.vol + 'L');
			$("#price_per_liter").html('$' + totals.price_per_liter.toFixed(2) + ' / L');		
		}
	}
};

jQuery(document).ready(function($) {	
	if ($('#brand_name').length) {
		$('#brand_name').change(function(e) {
			var val = $(this).val();
			$.ajax({
				url:_webDirectory + '/prices/view/'+val+'.json',
				success: function(data) {
					console.debug(data);
					prices = data;
					
					$('#package_size').autocomplete(data.packages, {
						matchContains: true,
						formatItem: function(item) {
							return item.Package.name;
						}
					}).result(function(event, item) {
						console.debug(item);
						$('#package_size').change();
					});
					
					/*$('#price').autocomplete(data.packages, {
						matchContains: true,
						formatItem: function(item) {
							return item.Price.amount;
						}
					}).result(function(event, item) {
						$('#price').change();
					});*/
				}
			});
		});
	
		$.ajax({
			url:_webDirectory + '/brands/index.json',
			dataType:'json',
			success:function(data) {
				var options = [];
				options.push("<option value='0'>Select Brand Name</option>");
				for(var i in data.brands) {
					var item = data.brands[i];
					//console.debug(item.Brand.name);
					options.push("<option value='" + item.Brand.id + "'>" + item.Brand.name + "</option>");
				}
				$('#brand_name').html(options.join('')).change();
			}
		});
	}
	$.ajax({
		url:_webDirectory + '/packages/index.json',
		dataType:'json',
		success:function(data) {
			//console.debug(data.packages);
			$('#package_size').autocomplete(data.packages, {
				matchContains: true,
				formatItem: function(item) {
					return item.Package.name;
				}
			}).result(function(event, item) {
				$('#package_size').change();
			});
		}
	});
	$('#package_size, #package_qty, #price').bind('change keyup blur', Event.input_changed());
	
});