$(document).ready(function() {
  if (localStorage['emails'] === undefined) {
    localStorage['emails'] = JSON.stringify(["admccarthy@gmail.com", "rsward@gmail.com"]);
    var rebecca = {"first_name":"Rebecca", "last_name": "Ward", "email": "rsward@gmail.com", "password": "passward", "credit_card": "3734123412341234", "provider": "MasterCard"};
    var arya = {"first_name":"Arya", "last_name": "McCarthy", "email": "admccarthy@gmail.com", "password": "facebook", "credit_card": "5432432143214321", "provider": "visa"};
    localStorage['users'] = JSON.stringify([rebecca, arya]);
  }

  var ticket = document.getElementById('active_ticket');
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

  /* A cheap hack, this doesn't preserve across pages.*/
  // TODO: Make not a cheap hack.
  $(document).on('submit', '#login_form', function (event) {
    event.preventDefault();
    var email = $("#login_email").val()
    if (userExists(email)) {
      var users = JSON.parse(localStorage['users']);
      for (var i = 0; i < users.length; ++i) {
        if (users[i]['email'] === email && users[i]['password'] === $("#login_password").val()) {
          localStorage.setItem("first_name", users[i]['first_name']);
          localStorage.setItem("last_name", users[i]['last_name']);
          localStorage.setItem("email", users[i]['email']);
          localStorage.setItem("password", users[i]['password']);
          localStorage.setItem("credit_card", users[i]['credit_card']);
          localStorage.setItem("provider", users[i]['provider']);
          showUser();
          return;
        }
      }
      alert("Incorrect password");
    } else {
      alert("Email does not exist.");
    }
  });

  $(document).on('submit', '#login', function (event) {
    event.preventDefault();
    if (!userExists($("#email").val())) {
      localStorage.setItem("first_name", $("#first_name").val());
      localStorage.setItem("last_name", $("#last_name").val());
      localStorage.setItem("email", $("#email").val());
      localStorage.setItem("password", $("#password").val());
      localStorage.setItem("credit_card", $("#credit_card").val());
      localStorage.setItem("provider", $("#provider").val());
      localStorage['emails'] = appendElementToJsonArray($("#email").val(), localStorage['emails']);
      var newUser = {
        "first_name": localStorage['first_name'],
        "last_name": localStorage['last_name'],
        "email": localStorage['email'],
        "password": localStorage['password'],
        "credit_card": localStorage['credit_card'],
        "provider": localStorage['provider']
      };
      localStorage['users'] = appendElementToJsonArray(newUser, localStorage['users']);
      window.location = 'index.html';
    }
    else {
      alert("Email is already in use.");
    }
  });
  showUser();
  $(document).on('submit', '#payment', function(event) {
    window.onbeforeunload = null;
  });
  
  $('[name="sides"]').on('change', limitSelectionToOne);
  $('[name="cheese"]').on('change', limitSelectionToOne);
});

function appendElementToJsonArray(str, json) {
  console.log(str);
  var arr = JSON.parse(json);
  console.log(arr);
  arr.push(str);
  console.log(arr);
  new_json = JSON.stringify(arr);
  console.log(new_json);
  return new_json;
}

function userExists(email) {
  return (localStorage['emails'] !== undefined) && (JSON.parse(localStorage['emails']).indexOf(email) !== -1);
}

function limitSelectionToOne(event) {
  var name = event.target.name;
  if ($('[name="' + name + '"]:checked').length > 1) {
    $(this).prop('checked', false);
    alert("You can only choose 1.");
  }
}

function showUser() {
  if (loggedIn()) {
    var first_name = getUserFirstName();
    var welcome = "Hello, " + first_name + "!";
    $("#user_hello").text(welcome);
    // $("#login_section").css('display', 'none');
    $("#user_section").css('display', 'inherit');
  }
}

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

function overlay() {
  var el = document.getElementById("paymentDialog");
  el.style.visibility = (el.style.visibility === "visible") ? "hidden" : "visible";
  prepopulate();
}

function prepopulate() {
  if (loggedIn()) {
    $("#first_name").val(getUserFirstName());
    $("#last_name").val(getUserLastName());
    $("#email").val(getUserEmail());
    $("#provider").val(getUserProvider());
    $("#credit_card").val(getUserCreditCard());
  }
}

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
  return $("[id^='ticketItem']").length !== 0
}
function guardPartialOrder() {
  window.onbeforeunload = wasOrdering() ? closeEditorWarning : null;
}

var ticketItemCounter = 0;
var ticketTotal=0.00; 

function updateTicket(selectedBurger) {
    var entry = document.createElement('li');
    entry.appendChild(document.createTextNode(selectedBurger));
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    createDeleteButton(entry);   
    createQuantityAdjuster(entry); 
    ticket.appendChild(entry);
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

function updateTicketTotal(userSetQuantity, burgerCost){
  var priceElement = document.getElementById('total_price');
  ticketTotal+= (userSetQuantity * burgerCost);
  priceElement.innerHTML=ticketTotal;
}


function updateTicketForCustomOrder() {
    var totalPrice=0; 
   
    var pattyId = document.querySelector('input[name = "patty"]:checked').id;
    var pattyPrice=document.getElementById(pattyId+"price").innerHTML;
    var pattyText=document.querySelector('input[name = "patty"]:checked').value;
    
    var bunId = document.querySelector('input[name = "bun"]:checked').id;
    var bunPrice = document.getElementById(bunId+"price").innerHTML;
    var bunText = document.querySelector('input[name = "bun"]:checked').value;

    var cheeseId="";
    var cheesePrice="";
    var cheeseText="";

    with(document.custom_order){
      for (var i=0; i<cheese.length; i++){
        if(cheese[i].checked){
         cheeseId = cheese[i].id;
         cheesePrice = document.getElementById(cheeseId+"price").innerHTML;
         cheeseText = document.querySelector('input[name = "cheese"]:checked').value
        }
      }
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

    totalPrice += +sidesPrice;
    var entry = document.createElement('li');
    var priceEntry = document.createElement('li');
    
    priceEntry.innerHTML=totalPrice;
    priceEntry.setAttribute('id', 'priceItem'+ticketItemCounter);

    var quantity = document.getElementById("burger_quantity").value;
    
    entry.innerHTML=(pattyText + " patty on a " + bunText + " bun with " + cheeseText+ "<br>Topped with: " + toppingsList+ "Sauces: " + sauceList + "Sides: " + sideList); 
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    
    createDeleteButton(entry);  
    createQuantityAdjuster(entry,quantity);
    updateTicketTotal(quantity, totalPrice); 
    ticketItemCounter+=1;

    
    ticket.appendChild(priceEntry);
    ticket.appendChild(entry);
    
    guardPartialOrder();
    clearCustomOrderForm();
}


function createQuantityAdjuster(ticketElement, userSetQuantity){
  var quantityAdjuster = document.createElement('input');
  quantityAdjuster.setAttribute('type','number');
  quantityAdjuster.setAttribute('name','quantity');
  quantityAdjuster.setAttribute('min','1');
  quantityAdjuster.setAttribute('max','10');
  quantityAdjuster.setAttribute('value', userSetQuantity);
  quantityAdjuster.setAttribute('id', 'adjuster'+ticketItemCounter);
  ticketElement.appendChild(quantityAdjuster);
}

function createDeleteButton(ticketElement){
    var deleteButton = document.createElement('button');
    deleteButton.appendChild(document.createTextNode("Delete"));
    deleteButton.setAttribute('onClick','removeTicketItem("'+'ticketItem'+ticketItemCounter+'","'+'priceItem'+ticketItemCounter+'","'+'adjuster'+ticketItemCounter+'")');
    ticketElement.appendChild(deleteButton);
}

function setIDsToChecked(ids) {
  for (var i = 0; i < ids.length; ++i) {
    $(ids[i]).prop('checked', true);
  }
}

function setIDsToUnchecked(ids) {
  for (var i = 0; i < ids.length; ++i) {
    $(ids[i]).prop('checked', false);
  }

}



function clearCustomOrderForm() {
  var radioIDs = ["#third_beef", "#white"];
  setIDsToChecked(radioIDs);
  var checkBoxIDs = ["#cheddar", "#swiss", "#american", "#tomatoes", "#lettuce", "#onions", "#pickles", "#red_onion", "#bacon", "#mushrooms", "#jalapenos", "#ketchup", "#mustard", "#mayonnaise", "#bbq", "#french_fries", "#tater_tots", "#onion_rings"];
  setIDsToUnchecked(checkBoxIDs);
  $("#burger_quantity").val(1);
}