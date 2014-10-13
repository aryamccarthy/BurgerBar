<!-- Homepage: opens to menu burger ordering page -->
<?php
$pageTitle = "Burger Bar";
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

	<section id="ordering">
		<nav>
			<ul>
				<!-- Links to each part of the menu  -->
				<li><a href="custom-order.html">Custom Order</a></li>
				<li><a href="index.html">Menu</a></li>
				<li><a href="past-orders.html">Past Orders</a></li>
			</ul>
		</nav>

		<!-- For each burger on the menu -->
		<figure>
			<img src=" " alt=" ">
			<figcapion class="burger_label">The Double Decker</figcaption>  
			<figcapion class="burger_description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod </figcaption>  
			<figcapion class="burger_price">$10.00</figcaption> 
			<button class="add_button" type="submit" formmethod=" ">Add</button>
		</figure>	
	</section>
</main>
<?php
include('include/footer.php');
?>