<div class="page_section" id="calc_cost">
	<ul>
		<li><h1>Price Browser</h1></li>
	</ul>
	<ul>
		<li><label for="brand_name">Brand</label></li>
		<li class="input">
			<select id="brand_name">
			</select>
		</li>
	
		<li><label for="package_size">Package</label></li>
		<li class="input">
			<select id="package_size">
			</select>
		</li>
	
		<li><label for="package_qty">Number Bought</label></li>
		<li class="input"><input type="text" id="package_qty" value="1"/></li>
	
		<li class='input'><input id='submit' onclick="e['function1'].getHTML(document.getElementById('returnValue'))" type='submit' value='Calculate'/></li>
	</ul>
	
	<ul>
		<li><span>Cost</span></li>
		<li class="output"><span id="cost">$0.00</span></li>
	</ul>

</div>
<div class="page_section" id="returnValue" style="display:none;"></div>

<div class="page_section" id="console"><pre></pre></div>
<?php $html->script('browse', false); ?>