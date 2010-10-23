<div class="page_section" id="calc_cost">
	<ul>
		<li><h1>Cost Calculator</h1></li>
		
		<li><span class="right">(optional)</span><label for="brand_name">Brand Name</label></li>
		<li class="input">
			<select type="text" name="brand_name" id="brand_name">
				<option id="default">-- Brands are loading --</option>
			</select>
		</li>
		
		<li><span class="right">(ex: 24 Bottles 355ml)</span><label for="package_size">Package</label></li>
		<li class="input">
			<input type="text" name="package_size" id="package_size" />
		</li>
		
		<li><label for="price">Package Price</label></li>
		<li class="input">
			<input type="text" id="price" value="$1.00"/>
		</li>
		
		<li><label for="package_qty">Number of Packages</label></li>
		<li class="input">
			<input type="text" id="package_qty" value="1"/>
		</li>
	</ul>
	
	<ul>
		<li><h1>Prices</h1></li>
	
		<li><span>Cost Per Litre</span></li>
		<li class="output"><span id="price_per_liter">$0.00</span></li>	
	</ul>
	<ul id="debug_output" style="display:none;">
		<li><span>Container Type</span></li>
		<li class="output"><span id="container_type">XXX</span></li>
		
		<li><span>Container Count</span></li>
		<li class="output"><span id="container_count">0</span></li>

		<li><span>Container Volume</span></li>
		<li class="output"><span id="container_volume">0</span></li>
		
		<li><span>Package Volume</span></li>
		<li class="output"><span id="package_volume">0L</span></li>

		<li><span>Cost Total</span></li>
		<li class="output"><span id="total_cost">$0.00</span></li>
		
		<li><span>Volume Total</span></li>
		<li class="output"><span id="total_volume">0L</span></li>		
	</ul>

</div>

<?php 
$html->script('calc', false); 
$html->script('jquery.autocomplete.pack', false); 
?>