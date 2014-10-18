<!-- Homepage: opens to menu burger ordering page -->
<?php
$pageTitle = "Burger Bar: Order";
include('include/header.php');
function getDBconnection() {
    try {
        $host = "localhost";
        $pdo = new PDO("mysql:host=$host;dbname=BurgerBar", "root", "root");
    } catch (PDOException $e) {
        $response = "Failed to connect: ";
        $response .= $e->getMessage();
        die ($response);
    }
    return $pdo;
}
?>
<main>
    <section id="ticket">
            <section>
                <h1>Ticket</h1>
            </section>
            <ul id="active_ticket">
                
            </ul>
        </section>

        <section id="ordering">
            <nav>
                <ul>
                    <!-- Links to each part of the menu  -->
                    <li><a id="custom_order_link" href="">Custom Order</a></li>
                    <li><a id="menu_order_link" href="">Menu</a></li>
                    <li><a id="past_order_link" href="">Past Orders</a></li>
                </ul>
            </nav>
            <article id="custom_ordering" class="selected">
                <form name="custom_order" action="" method="">
                    <?php
                        //Get menu info from DB
                        $pdo = getDBconnection();
                        $statement = $pdo->prepare(
                            "SELECT
                                MenuComponent.idMenuComponent AS idComponent,
                                MenuComponent.name AS componentName,
                                idMenuItem AS idItem,
                                MenuItem.name As itemName,
                                isSingle,
                                price
                            FROM MenuItem
                            JOIN MenuComponent
                            ON (MenuItem.idMenuComponent= MenuComponent.idMenuComponent)
                            ORDER BY idComponent;");
                        if($statement->execute()) {
                                $idComponent = null;
                                $components = null;
                            while($row = $statement->fetch()) {
                                if ($idComponent != $row['idComponent']) {
                                    $idComponent = $row['idComponent'];
                                    $components[$idComponent]['name'] = $row['componentName'];
                                    //TODO: get 0-n, 0-1, etc.
                                    $components[$idComponent]['items'] = array();
                                    $components[$idComponent]['isSingle'] = $row['isSingle'];
                                }
                                $item['idItem'] = (int)$row['idItem'];
                                $item['name'] = $row['itemName'];
                                $item['price'] = (int) $row['price'];
                                array_push($components[$idComponent]['items'], $item);
                            }
                        } else {
                            echo "<div>Error occurred. Please reload page.</div>";
                        }

                        //Generate html
                        foreach($components as $component) {
                            echo '<fieldset>';
                            echo '<legend>'.$component['name']."</legend>";
                            echo '<ol>';
                            foreach ($component['items'] as $item) {
                                echo '<li>';
                                if ($component['isSingle'] == true) {
                                    echo '<input type="radio" name="'.$component['name'].'" id="item-'.$item['idItem'].'" value="'.$item['name'].'">';
                                } else {
                                    echo '<input type="checkbox" name="'.$component['name'].'" id="item-'.$item['idItem'].'" value="'.$item['name'].'">';
                                } 
                                echo '<label for="'.$item['name'].'">'.$item['name'].'</label>';
                                echo '</li>';
                            }
                            echo '</ol>';
                            echo '</fieldset>';
                        }
                    ?>
                    <!-- <fieldset>
                        <legend>Order a custom burger</legend>
                        <fieldset>
                            <legend>Burger type</legend>
                            <ol>
                                <li>
                                    <input type="radio" name="patty" id="third_beef" value="1/3 lb. Beef" checked>
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
                                    <input type="radio" name="bun" id="white" value="White" checked>
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
                                    <input type="radio" name="cheese" id="cheddar" value="Cheddar" checked>
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
                                    <input type="checkbox" name="toppings" id="bacon" value="Bacon">
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
                                    <label for="tater_tots">Tater tots&#0153;</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="sides" id="onion_rings" value="Onion rings">
                                    <label for="onion_rings">Onion rings</label>
                                </li>
                            </ol>
                        </fieldset>
                        <fieldset>
                            <input type='button' onclick='updateTicketForCustomOrder();' value='Add to ticket' />
                        </fieldset>
                    </fieldset> -->
                </form>
            </article>
            <article id="menu_ordering">
            <!-- For each burger on the menu -->
            <!-- Descriptions from http://en.wikipedia.org/wiki/List_of_hamburgers -->
                <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label" value="Buffalo Burger">Buffalo Burger</figcaption>  
                    <figcaption class="burger_description">Prepared with meat from the American Bison, buffalo burgers have less cholesterol, less fat, and fewer calories than beef hamburgers and chicken hamburgers. The American Heart Association recommended buffalo burgers in 1997 as more heart-healthy than chicken or beef. </figcaption>  
                    <figcaption class="burger_price">$9.50</figcaption> 
                    <input type='button' id="Buffalo Burger" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>   
                <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label" value="Jucy Lucy">Jucy Lucy</figcaption>  
                    <figcaption class="burger_description">A cheeseburger that has the cheese inside the meat patty rather than on top. A piece of cheese is surrounded by raw meat and cooked until it melts, resulting in a molten core of cheese within the patty. </figcaption>  
                    <figcaption class="burger_price">$9.00</figcaption> 
                    <input type='button' id="Jucy Lucy" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>   
                <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label">Hamdog</figcaption>  
                    <figcaption class="burger_description">An American dish that consists of a hot dog that is wrapped in a beef patty, deep-fried, covered with chili, a handful of French fries, and a fried egg. </figcaption>  
                    <figcaption class="burger_price">$8.75</figcaption> 
                    <input type='button' id="Hamdog" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>   
                <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label">Luther Burger</figcaption>  
                    <figcaption class="burger_description">A hamburger or cheeseburger prepared with one or more glazed doughnuts in place of the bun. </figcaption>  
                    <figcaption class="burger_price">$8.00</figcaption> 
                    <input type='button' id="Luther Burger" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>   
                 <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label">Teriyaki Burger</figcaption>  
                    <figcaption class="burger_description">Teriyaki burger (テリヤキバーガー?) refers to a variety of hamburger either topped with teriyaki sauce or with the sauce worked into the ground meat patty. </figcaption>  
                    <figcaption class="burger_price">$7.50</figcaption> 
                    <input type='button' id="Teriyaki Burger" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>
                 <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/  Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,     Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcaption class="burger_label">Naan Burger</figcaption>  
                    <figcaption class="burger_description">Made with naan bread, naan burgers, the use of flatbread creates a taste experience different from hamburgers made with bread.
                    </figcaption>  
                    <figcaption class="burger_price">$8.75</figcaption> 
                    <input type='button' id="Naan Burger" onclick='updateTicket(this.id)' value='Add to ticket' />
                </figure>
            </article>
    
        <article id="past_ordering">
            <!-- For each past order-->
                <figure>
                    <img src="https://openclipart.org/image/200px/svg_to_png/9096/          Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food, <Lunch->            </Lunch->Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />
                    <figcapion class="burger_label">Past Order</figcaption>  
                    <figcapion class="burger_description">Lorem ipsum dolor sit amet,           consectetur adipisicing elit, sed do eiusmod </figcaption>  
                    <figcapion class="burger_price">$10.00</figcaption> 
                    <button class="add_button" type="submit" formmethod=" ">Add</button>
                </figure>   
        </article>
    </section>

    <button onclick="overlay()">Pay now</button>

    <dialog id="paymentDialog">
        <form id="payment" action="order-confirmation.hp">
            <fieldset>
                <legend>Your details</legend>
                <ol>
                    <li>
                        <label for="first_name">First Name</label>
                        <input id="first_name" name="first_name" type="text" placeholder="First Name" value=<?php echo '"'.$_SESSION['userInfo']['fName'].'"';?>required autofocus>
                    </li>
                    <li>
                        <label for="last_name">Last name</label>
                        <input id="last_name" name="last_name" type="text" placeholder="Last name" value=<?php echo '"'.$_SESSION['userInfo']['lName'].'"'?>required>
                    </li>
                    <li>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="example@domain.com" value=<?php echo '"'.$_SESSION['userInfo']['email'].'"'?>required>
                    </li>   
                    <li>
                        <label for=provider>Provider</label>
                        <select name="provider" id="provider">
                        <option value="visa" <?php if (strtolower($_SESSION["userInfo"]["cardType"]=="visa")) echo 'selected'?>>Visa</option>
                        <option value="masterCard" <?php if (strtolower($_SESSION["userInfo"]["cardType"]=="mastercard")) echo 'selected'?>>MasterCard</option>
                        <option value="americanExpress"<?php if (strtolower($_SESSION["userInfo"]["cardType"]=="americanexpress")) echo 'selected'?>>American Express</option>
                    </select>
                    </li>

                    <li>
                        <label for="credit_card">Credit card</label>
                        <input id="credit_card" name="credit_card" type="text" placeholder="Credit card number" value=<?php echo '"'.$_SESSION['userInfo']['cardNum'].'"'?>
                            pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$" required>
                            <!--Regex c/o http://www.regular-expressions.info/creditcard.html-->
                    </li>
                </ol>
            </fieldset>
            
            <fieldset>
                <input type="submit" value="Place order">
                <button type="button" onclick="overlay()">Cancel</button>
            </fieldset>
        </form>
    </dialog>
</main>
<?php
include('include/footer.php');
?>