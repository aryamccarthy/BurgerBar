$(document).ready(function() {
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
    var first_name = $("#login_email").val(); // CHANGE THIS.
    $("#user_hello").text(first_name);
    $("#login_section").hide();
    $("#user_section").show();
  });

  $(document).on('submit', '#login', function (event) {
    event.preventDefault();
    localStorage.setItem("first_name", $("#first_name").val());
    localStorage.setItem("last_name", $("#last_name").val());
    localStorage.setItem("email", $("#email").val());
    localStorage.setItem("password", $("#password").val());
    localStorage.setItem("credit_card", $("#credit_card").val());
    localStorage.setItem("provider", $("#provider").val());
    window.location = 'index.php'; //Luke changed this to .php
  });
  showUser();
  $(document).on('submit', '#payment', function(event) {
    window.onbeforeunload = null;
  });
});

function showUser() {
  if (loggedIn()) {
    var first_name = getUserFirstName();
    var welcome = "Hello, " + first_name + "!";
    $("#user_hello").text(welcome);
    $("#login_section").css('display', 'none');
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

//for menu burgers and past orders
// NOTE: When pulling past orders from the database, 
// be sure to put the burger name in the id field for the input button
function updateTicket(selectedBurger) {
    var entry = document.createElement('li');
    entry.appendChild(document.createTextNode(selectedBurger));
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    createDeleteButton(entry);   
    createQuantityAdjuster(entry); 
    ticket.appendChild(entry);
    guardPartialOrder();       
}

function removeTicketItem(itemId){
    var item = document.getElementById(itemId);
    ticket.removeChild(item);
    guardPartialOrder();
}
// http://stackoverflow.com/questions/23504528/dynamically-remove-items-from-list-javascript




// TODO: clean up this function's output to the tickt (commas, grammar, etc)
function updateTicketForCustomOrder() {
    var patty = document.querySelector('input[name = "patty"]:checked').value;
    var pattyPrice = document.querySelector('input[name = "patty"]:checked').price;
    var bun = document.querySelector('input[name = "bun"]:checked').value;
    var cheese = document.querySelector('input[name = "cheese"]:checked').value;
    var toppingsList= "";

    with(document.custom_order){
      for(var i = 0; i < toppings.length; i++){
        if(toppings[i].checked) {
          toppingsList += toppings[i].value + "\n ";
        }
      }
    }
    var sauceList="";
    with(document.custom_order){
      for(var i = 0; i < sauces.length; i++){
        if(sauces[i].checked) {
          sauceList += sauces[i].value + "\n ";
        }
      }
    }
    var sideList="";
    with(document.custom_order){
      for(var i = 0; i < sides.length; i++){
        if(sides[i].checked) {
          sideList += sides[i].value + "\n ";
        }
      }
    }  

    var entry = document.createElement('li');
    entry.innerHTML=(patty + " patty on a " + bun + " bun with " + cheese + "<br> Topped with: " + toppingsList + "<br>Sauces: " + sauceList + "<br> Sides: " +sideList );
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    createDeleteButton(entry);  
    createQuantityAdjuster(entry); 
    ticket.appendChild(entry);
    guardPartialOrder();
    clearCustomOrderForm();
}

function createQuantityAdjuster(ticketElement){
  var quantityAdjuster = document.createElement('input');
  quantityAdjuster.setAttribute('type','number');
  quantityAdjuster.setAttribute('name','quantity');
  quantityAdjuster.setAttribute('min','1');
  quantityAdjuster.setAttribute('max','10');
  quantityAdjuster.setAttribute('value','1');
  ticketElement.appendChild(quantityAdjuster);
}

function createDeleteButton(ticketElement){
    var deleteButton = document.createElement('button');
    deleteButton.appendChild(document.createTextNode("Delete"));
    deleteButton.setAttribute('onClick','removeTicketItem("'+'ticketItem'+ticketItemCounter+'")');
    ticketElement.appendChild(deleteButton);
    ticketItemCounter+=1;
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
  var radioIDs = ["#third_beef", "#white", "#cheddar"];
  setIDsToChecked(radioIDs);
  var checkBoxIDs = ["#tomatoes", "#lettuce", "#onions", "#pickles", "#red_onion", "#bacon", "#mushrooms", "#jalapenos", "#ketchup", "#mustard", "#mayonnaise", "#bbq", "#french_fries", "#tater_tots", "#onion_rings"];
  setIDsToUnchecked(checkBoxIDs);
}