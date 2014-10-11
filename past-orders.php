<?php
	$pageTitle = "Burger Bar: Past Orders";
	include('include/header.php');
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

	<!-- Links to each part of the menu  -->
	<h2 class="menu_section"><a href="custom-order.html">Custom Order</a></h2>
	<h2 class="menu_section"><a href="index.html">Menu Burger</a></h2>
	<h2 class="menu_section"><a href="past-orders.html">Past Orders</h2>

	<section id="past_ordering">
		<nav>
			<ul>
			<!-- Links to each part of the menu  -->
				<li><a href="custom-order.html">Custom Order</a></li>
				<li><a href="index.html">Menu</a></li>
				<li><a href="past-orders.html">Past Orders</a></li>
			</ul>
		</nav>
		<!-- For each past order-->
		<figure>
			<img src=" " alt=" ">
			<figcapion class="burger_label">Past Order</figcaption>  
			<figcapion class="burger_description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod </figcaption>  
			<figcapion class="burger_price">$10.00</figcaption> 
			<button class="add_button" type="submit" formmethod=" ">Add</button>
		</figure>	
	</section>
</main>

<?php
	include('include/footer.php');
?>