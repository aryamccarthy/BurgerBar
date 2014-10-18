$(document).ready(function() {
  if (localStorage.emails === undefined) {
    // This is a cheap hack to test whether someone is logged in.
    // We use localStorage to create a mock set of accounts.
    localStorage.emails = JSON.stringify(["admccarthy@gmail.com", "rsward@gmail.com"]);
    var rebecca = {"first_name":"Rebecca", "last_name": "Ward", "email": "rsward@gmail.com", "password": "passward", "credit_card": "3734123412341234", "provider": "MasterCard"};
    var arya = {"first_name":"Arya", "last_name": "McCarthy", "email": "admccarthy@gmail.com", "password": "facebook", "credit_card": "5432432143214321", "provider": "visa"};
    localStorage.users = JSON.stringify([rebecca, arya]);
    var an_order = '<figure> \
          <img src="https://openclipart.org/image/200px/svg_to_png/9096/Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,   Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" /> \
          <figcaption class="burger_label">Naan Burger</figcaption>   \
          <figcaption class="burger_description">Made with naan bread, naan burgers, the use of flatbread creates a taste experience different from hamburgers made with bread. \
          </figcaption>   \
          <figcaption class="burger_price" id="Naan Burger_price">8.75</figcaption> \
          <input type="button" id="Naan Burger" onclick="updateTicket(this.id)" value="Add to ticket" /> \
        </figure> \
        <figure> \
          <img src="https://openclipart.org/image/200px/svg_to_png/9096/Gerald_G_Fast_Food_Lunch_Dinner_(FF_Menu)_22.png" title="Fast Food,   Lunch-Dinner, Hamburger by  Gerald_G (/user-detail/Gerald_G)" />\
          <figcaption class="burger_label">Luther Burger</figcaption>  \
          <figcaption class="burger_description">A hamburger or cheeseburger prepared with one or more glazed doughnuts in place of the bun. </figcaption>\
          <figcaption class="burger_price" id="Luther Burger_price">8.00</figcaption> \
          <input type="button" id="Luther Burger" onclick="updateTicket(this.id)" value="Add to ticket" />\
        </figure> \
';
    var arya_order = {"email": "admccarthy@gmail.com", "order": [an_order]};
    var pastOrders = [arya_order];
    localStorage.pastOrders = JSON.stringify(pastOrders);
  }

  // If logged in and you have past orders, show them.
  if ($("#past_ordering").length !== 0) {
    if (loggedIn()) {
      var all_orders = JSON.parse(localStorage.pastOrders);
      for (var c = 0; c < all_orders.length; ++c) {
        if (all_orders[c].email === getUserEmail()) {
          var result = "";
          for (var d = 0; d < all_orders[c].order.length; ++d) {
            result += all_orders[c].order[d];
          }
          $("#past_ordering").html(result);
        }
      }
    }
  }
  var ticket = document.getElementById('active_ticket');
  // These three actions allow only one of the three ordering panes to show.
  $("#custom_order_link").click(function(event){
    event.preventDefault();
    $("#custom_ordering").addClass("selected");
    $("#menu_ordering").removeClass("selected");
    $("#past_ordering").removeClass("selected");
  });
  $("#menu_order_link").click(function(event){
    event.preventDefault();
    $("#custom_ordering").removeClass("selected");
    $("#menu_ordering").addClass("selected");
    $("#past_ordering").removeClass("selected");
  });
  $("#past_order_link").click(function(event){
    event.preventDefault();
    $("#custom_ordering").removeClass("selected");
    $("#menu_ordering").removeClass("selected");
    $("#past_ordering").addClass("selected");
  });

  // Faked login form.
  $(document).on('submit', '#login_form', function (event) {
    event.preventDefault();
    var email = $("#login_email").val();
    if (userExists(email)) {
      // Pulls user data, storing locally.
      var users = JSON.parse(localStorage.users);
      for (var i = 0; i < users.length; ++i) {
        if (users[i].email === email && users[i].password === $("#login_password").val()) {
          localStorage.first_name = users[i].first_name;
          localStorage.last_name = users[i].last_name;
          localStorage.email = users[i].email;
          localStorage.password = users[i].password;
          localStorage.credit_card = users[i].credit_card;
          localStorage.provider = users[i].provider;
          showUser();
          return;
        }
      }
      alert("Incorrect password");
    } else {
      alert("Email does not exist.");
    }
  });

  // Logs user in. Checks everything.
  $(document).on('submit', '#login', function (event) {
    event.preventDefault();
    if (!userExists($("#email").val())) {
      localStorage.first_name = $("#first_name").val();
      localStorage.last_name = $("#last_name").val();
      localStorage.email = $("#email").val();
      localStorage.password = $("#password").val();
      localStorage.credit_card = $("#credit_card").val();
      localStorage.provider = $("#provider").val();
      localStorage.emails = appendElementToJsonArray($("#email").val(), localStorage.emails);
      var newUser = {
        "first_name": localStorage.first_name,
        "last_name": localStorage.last_name,
        "email": localStorage.email,
        "password": localStorage.password,
        "credit_card": localStorage.credit_card,
        "provider": localStorage.provider
      };
      localStorage.users = appendElementToJsonArray(newUser, localStorage.users);
      window.location = 'index.html';
    }
    else {
      alert("Email is already in use.");
    }
  });
  showUser();
  // Guards against partial orders.
  $(document).on('submit', '#payment', function(event) {
    window.onbeforeunload = null;
  });
  
  // For the two things that are selectable 0-1.
  $('input:checkbox[name="sides"]').click(limitSelectionToOne);
  $("input:checkbox[name='cheese']").click(limitSelectionToOne);
});

function appendElementToJsonArray(elem, json) {
  var arr = JSON.parse(json);
  arr.push(elem);
  var new_json = JSON.stringify(arr);
  return new_json;
}

// Checks localStorage. Update if API is ready.
function userExists(email) {
  return (localStorage.emails !== undefined) && (JSON.parse(localStorage.emails).indexOf(email) !== -1);
}

// Restricts selectable elements from a checkbox group.
function limitSelectionToOne() {
    if ($(this).is(":checked")) {
        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(group).prop("checked", false);
        $(this).prop("checked", true);
    } else {
        $(this).prop("checked", false);
    }
}

// Swaps message if user is logged in.
function showUser() {
  if (loggedIn()) {
    var first_name = getUserFirstName();
    var welcome = "Hello, " + first_name + "!";
    $("#user_hello").text(welcome);
    $("#login_section").css('display', 'none');
    $("#user_section").css('display', 'inherit');
  }
}

// Getters
function getUserFirstName() {
  return localStorage.getItem("first_name");
}
function getUserLastName() {
  return localStorage.getItem("last_name");
}
function getUserEmail() {
  return localStorage.getItem("email");
}
function getUserProvider() {
  return localStorage.getItem("provider");
}
function getUserCreditCard() {
  return localStorage.getItem("credit_card");
}

// Sets up payment dialog and fills data if logged in.
function overlay() {
  var el = document.getElementById("paymentDialog");
  el.style.visibility = (el.style.visibility === "visible") ? "hidden" : "visible";
  prepopulate();
}

// Fills diaog data.
function prepopulate() {
  if (loggedIn()) {
    $("#first_name").val(getUserFirstName());
    $("#last_name").val(getUserLastName());
    $("#email").val(getUserEmail());
    $("#provider").val(getUserProvider());
    $("#credit_card").val(getUserCreditCard());
  }
}

// Checks using cheap hack. Update when API is ready.
function loggedIn() {
  return localStorage.getItem("first_name") !== null;
}


/* Protects your partially-filled custom order form.
 * Source: http://stackoverflow.com/questions/7317273/warn-user-before-leaving-page-with-unsaved-changes
 */
function closeEditorWarning() {
    return 'It looks like you were preparing an order -- if you leave before submitting your order will be lost.';
}
/** Returns whether there are items in the current ticket. */
function wasOrdering() {
  return $("[id^='ticketItem']").length !== 0;
}
// If was ordering, warn that trying to close editor.
function guardPartialOrder() {
  window.onbeforeunload = wasOrdering() ? closeEditorWarning : null;
}


var ticketItemCounter = 0;
var ticketTotal=0.00; 
var quantityCheck = document.getElementsByClassName('adjuster');

//Updates that ticket with past orders and menu burgers that the user adds
function updateTicket(selectedBurger) {
    //Create list elements for the burger and its price
    var entry = document.createElement('li');
    var priceEntry=document.createElement('li');
    
    //Retreive data from selected burger
    var quantity = document.getElementById("burger_quantity").value;
    var price= document.getElementById(selectedBurger+"_price").innerHTML;
    
    //Attach that data to the new elements with unique ids for easy deletion  
    priceEntry.innerHTML=price;
    priceEntry.setAttribute('id', 'priceItem'+ticketItemCounter);
    entry.appendChild(document.createTextNode(selectedBurger));
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
   
    //Create buttons for adjusting quantity within ticket, deletion
    //Update the ticket total
    createDeleteButton(entry);   
    var cost=document.getElementById('totalPrice');
    createQuantityAdjuster(entry, quantity, price); 
    updateTicketTotal(quantity, price);
    priceEntry.setAttribute("class","burger_price");
    ticket.appendChild(entry);
    ticket.appendChild(priceEntry);
    guardPartialOrder();       
}

//Tips from: http://stackoverflow.com/questions/23504528/dynamically-remove-items-from-list-javascript
function removeTicketItem(itemId, priceId, quantityId){ 
    var item = document.getElementById(itemId);
    var priceItem=document.getElementById(priceId);
    var quantityItem=document.getElementById(quantityId);
    var priceBuffer=priceItem.innerHTML;
    updateTicketTotal(+quantityItem.value, (+priceBuffer * -1));
    ticket.removeChild(item);
    ticket.removeChild(priceItem);
    ticket.removeChild(quantityItem);

    guardPartialOrder();
}

//Updates the ticket total when a user changes the quantity, a burger is added, or deleted
function updateTicketTotal(userSetQuantity, burgerCost){
  var priceElement = document.getElementById('total_price');
  ticketTotal+= (userSetQuantity * burgerCost);
  priceElement.innerHTML=ticketTotal.toFixed(2);
}

//Adds custom orders to the ticket
function updateTicketForCustomOrder() {
    var totalPrice=0; 
   
    //Retieve selected burger options from the form
    //Increment the totalPrice of the burger as each option is retieved 
    var pattyId = document.querySelector('input[name = "patty"]:checked').id;
    var pattyPrice=document.getElementById(pattyId+"price").innerHTML;
    var pattyText=document.querySelector('input[name = "patty"]:checked').value;
    
    var bunId = document.querySelector('input[name = "bun"]:checked').id;
    var bunPrice = document.getElementById(bunId+"price").innerHTML;
    var bunText = document.querySelector('input[name = "bun"]:checked').value;

    var cheeseId="";
    var cheesePrice="";
    var cheeseText="";
    var isThereCheese = true;
    with(document.custom_order){
      for (var i=0; i<cheese.length; i++){
        if(cheese[i].checked){
         cheeseId = cheese[i].id;
         cheesePrice = document.getElementById(cheeseId+"price").innerHTML;
         cheeseText = document.querySelector('input[name = "cheese"]:checked').value;
        }
      }
    }
    if (cheeseText == ""){
      cheeseText="none";
    }
    totalPrice += +pattyPrice;
    totalPrice += +bunPrice;
    totalPrice += +cheesePrice;
    
    var toppingsList= "";
    var sauceList="";
    var toppingsPrice=0;
    var sidesPrice=0;

    with(document.custom_order){
      for(var i = 0; i < toppings.length; i++){
        if(toppings[i].checked) {
          toppingsList += toppings[i].value + "<br> ";
          var toppingsId=toppings[i].id;
          toppingsPrice+= +document.getElementById(toppingsId+"price").innerHTML;
        }
      }
    }
    totalPrice += +toppingsPrice;

    with(document.custom_order){
      for(var i = 0; i < sauces.length; i++){
        if(sauces[i].checked) {
          sauceList += sauces[i].value + "<br>";
        }
      }
    }
    if (sauceList===""){
      sauceList="none <br>";
    }
    if (toppingsList===""){
      toppingsList= "none <br>";
    }
    var sideList="";
    with(document.custom_order){
      for(var i = 0; i < sides.length; i++){
        if(sides[i].checked) {
          sideList += sides[i].value + "<br>";
          var sidesId=sides[i].id;
          sidesPrice+= +document.getElementById(sidesId+"price").innerHTML;
        }
      }
    }  
    if (sideList===""){
      sideList="none <br>";
    }

    totalPrice += +sidesPrice;
    //Create elements to display the price and burger information
    var entry = document.createElement('li');
    var priceEntry = document.createElement('li');
    
    //Attach data to elements, create unique ids for easy deletion
    priceEntry.innerHTML=totalPrice.toFixed(2);
    priceEntry.setAttribute('id', 'priceItem'+ticketItemCounter);
    priceEntry.setAttribute("class","burger_price");
    var quantity = document.getElementById("burger_quantity").value;
    entry.innerHTML=(pattyText + " patty on a " + bunText + " bun <br> Cheese: "  + cheeseText+ "<br>Toppings: " + toppingsList+ "Sauces: " + sauceList + "Sides: " + sideList); 
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    
    //Create delete button, quantity adjuster, update the total on the ticket
    createDeleteButton(entry);  
    createQuantityAdjuster(entry,quantity, totalPrice);
    updateTicketTotal(quantity, totalPrice); 
    ticketItemCounter+=1;
    
    //Attach elements to ticket, clear form for next order 
    ticket.appendChild(entry);
    ticket.appendChild(priceEntry);
    guardPartialOrder();
    clearCustomOrderForm();
}


function createQuantityAdjuster(ticketElement, userSetQuantity, burgerPrice){
  var quantityAdjuster = document.createElement('input');
  quantityAdjuster.setAttribute('class', 'adjuster');
  quantityAdjuster.setAttribute('type','number');
  quantityAdjuster.setAttribute('name','quantity');
  quantityAdjuster.setAttribute('min','1');
  quantityAdjuster.setAttribute('max','10');
  quantityAdjuster.setAttribute('value', userSetQuantity);
  quantityAdjuster.setAttribute('id', 'adjuster'+ticketItemCounter);
  ticketElement.appendChild(quantityAdjuster);

  // Help from: http://stackoverflow.com/questions/18156824/restricting-an-input-box-to-only-numbers-0-9
  quantityAdjuster.onkeydown = function(e) {
    var key = e.keyCode ? e.keyCode : e.which;
    if ( isNaN( String.fromCharCode(key) ) ) return false;
  }

  var previousQuantity= +quantityAdjuster.value; 
  
  //Checks for users changing the quantity within the ticket
  //Updates the ticket total accordingly
  quantityAdjuster.addEventListener("input", function(e) {

    if (quantityAdjuster.value>10){
      quantityAdjuster.value=10;
    }
     if (quantityAdjuster.value<0){
      quantityAdjuster.value=1;
    }
    var priceElement = document.getElementById('total_price');
    
    //If the user increments/decrements by 1
    if((quantityAdjuster.value - previousQuantity)==1){
      if(quantityAdjuster.value> previousQuantity){
        ticketTotal+= +burgerPrice;
        priceElement.innerHTML=ticketTotal.toFixed(2);
      }
      else {
        ticketTotal-= +burgerPrice;
        priceElement.innerHTML=ticketTotal.toFixed(2);
      }
    }
    //Else the user manually inputted a number
    else {
     if(quantityAdjuster.value> previousQuantity){
      var quantityDifference = +quantityAdjuster.value - +previousQuantity;
        ticketTotal+=(+burgerPrice * quantityDifference);
        priceElement.innerHTML=ticketTotal.toFixed(2);
      }
      else {
        var quantityDifference = +previousQuantity- +quantityAdjuster.value;
        ticketTotal-= (+burgerPrice * +quantityDifference);
        priceElement.innerHTML=ticketTotal.toFixed(2);
      }
    }
    previousQuantity=quantityAdjuster.value; 
  }, false);
}

function createDeleteButton(ticketElement){
    var deleteButton = document.createElement('button');
    deleteButton.appendChild(document.createTextNode("Delete"));
    deleteButton.setAttribute("class", "deleteTicketItemButton");
    deleteButton.setAttribute('onClick','removeTicketItem("'+'ticketItem'+ticketItemCounter+'","'+'priceItem'+ticketItemCounter+'","'+'adjuster'+ticketItemCounter+'")');
    ticketElement.appendChild(deleteButton);
}

// Checks all items in range.
function setIDsToChecked(ids) {
  for (var i = 0; i < ids.length; ++i) {
    $(ids[i]).prop('checked', true);
  }
}

// Unchecks all elements in range.
function setIDsToUnchecked(ids) {
  for (var i = 0; i < ids.length; ++i) {
    $(ids[i]).prop('checked', false);
  }

}

// Ready to clear form to defaults when item added to ticket or asked to clear.
function clearCustomOrderForm() {
  var radioIDs = ["#third_beef", "#white"];
  setIDsToChecked(radioIDs);
  var checkBoxIDs = ["#cheddar", "#swiss", "#american", "#tomatoes", "#lettuce", "#onions", "#pickles", "#red_onion", "#bacon", "#mushrooms", "#jalapenos", "#ketchup", "#mustard", "#mayonnaise", "#bbq", "#french_fries", "#tater_tots", "#onion_rings"];
  setIDsToUnchecked(checkBoxIDs);
  $("#burger_quantity").val(1);
}