<?php
	include('ref/header.php');
?>
	
<main>
	<section id="ticket">
		<header>
			<h1>Ticket</h1>
		</header>
		<ul>
			<li>Item1</li>
			<li>Item2</li>
		</ul>
	</section>
	<section id="ordering">
		<nav>
			<ul>
				<!-- Links to each part of the menu  -->
				<li><a href="custom-order.html">Custom Order</a></li>
				<li><a href="index.html">Menu</a></li>
				<li><a href="past-orders.html">Past Orders</a></li>
			</ul>
		</nav>
		<article>
			<!--
				TODO: Fill in the menu with content from the DB
			-->
			<form action="" method="">
				<fieldset>
					<legend>Order a custom burger</legend>
					<fieldset>
						<legend>Burger type</legend>
						<ol>
							<li>
								<input type="radio" name="patty" id="third_beef" value="1/3 lb. Beef">
								<label for="third_beef">1/3 lb. Beef</label>
							</li>
							<li>
								<input type="radio" name="patty" id="half_beef" value="1/2 lb. Beef">
								<label for="half_beef">1/2 lb. Beef</label>
							</li>
							<li>
								<input type="radio" name="patty" id="two_thirds_beef" value="2/3 lb. Beef">
								<label for="two_thirds_beef">2/3 lb. Beef</label>
							</li>
							<li>
								<input type="radio" name="patty" id="turkey" value="Turkey">
								<label for="turkey">Turkey</label>
							</li>
							<li>
								<input type="radio" name="patty" id="veggie" value="Veggie">
								<label for="veggie">Veggie</label>
							</li>								
						</ol>
					</fieldset>
					<fieldset>
						<legend>Bun</legend>
						<ol>
							<li>
								<input type="radio" name="bun" id="white" value="White">
								<label for="white">White</label>
							</li>
							<li>
								<input type="radio" name="bun" id="wheat" value="Wheat">
								<label for="wheat">Wheat</label>
							</li>
							<li>
								<input type="radio" name="bun" id="texas_toast" value="Texas Toast">
								<label for="texas_toast">Texas Toast</label>
							</li>
						</ol>
					</fieldset>
					<fieldset>
						<legend>Cheese</legend>
						<ol>
							<li>
								<input type="radio" name="cheese" id="cheddar" value="Cheddar">
								<label for="cheddar">Cheddar</label>
							</li>
							<li>
								<input type="radio" name="cheese" id="american" value="American">
								<label for="american">American</label>
							</li>
							<li>
								<input type="radio" name="cheese" id="swiss" value="Swiss">
								<label for="swiss">Swiss</label>
							</li>
							<li>
								<input type="radio" name="cheese" id="no_cheese" value="No Cheese">
								<label for="no_cheese">No Cheese</label>
							</li>
						</ol>
					</fieldset>
					<fieldset>
						<legend>Toppings</legend>
						<ol>
							<li>
								<input type="checkbox" name="toppings" id="tomatoes" value="Tomatoes">
								<label for="tomatoes">Tomatoes</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="lettuce" value="Lettuce">
								<label for="lettuce">Lettuce</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="onions" value="Onions">
								<label for="onions">Onions</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="pickles" value="Pickles">
								<label for="pickles">Pickles</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="bacon" value="Pickles">
								<label for="bacon">Bacon</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="red_onion" value="Red onion">
								<label for="red_onion">Red onion</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="mushrooms" value="Mushrooms">
								<label for="mushrooms">Mushrooms</label>
							</li>
							<li>
								<input type="checkbox" name="toppings" id="jalapenos" value="Jalapenos">
								<label for="jalapenos">Jalapenos</label>
							</li>
						</ol>
					</fieldset>
					<fieldset>
						<legend>Sauces</legend>
						<ol>
							<li>
								<input type="checkbox" name="sauces" id="ketchup" value="Ketchup">
								<label for="ketchup">Ketchup</label>
							</li>
							<li>
								<input type="checkbox" name="sauces" id="mustard" value="Mustard">
								<label for="mustard">Mustard</label>
							</li>
							<li>
								<input type="checkbox" name="sauces" id="mayonnaise" value="Mayonnaise">
								<label for="mayonnaise">Mayonnaise</label>
							</li>
							<li>
								<input type="checkbox" name="sauces" id="bbq" value="BBQ">
								<label for="bbq">BBQ</label>
							</li>
						</ol>
					</fieldset>
					<fieldset>
						<legend>Sides</legend>
						<ol>
							<li>
								<input type="checkbox" name="sides" id="french_fries" value="French fries">
								<label for="french_fries">French fries</label>
							</li>
							<li>
								<input type="checkbox" name="sides" id="tater_tots" value="Tater tots">
								<label for="tater_tots">Tator tots</label>
							</li>
							<li>
								<input type="checkbox" name="sides" id="onion_rings" value="Onion rings">
								<label for="onion_rings">Onion rings</label>
							</li>
						</ol>
					</fieldset>
					<fieldset>
						<button type="submit">Add to order</button>
					</fieldset>
				</fieldset>
			</form>
		</article>
	</section>
</main>

<?php
include('ref/footer.php');
?>