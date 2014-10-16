$(document).ready(function() {
	//TODO: Delete fillCommonTags(). See note below. -Luke
	fillCommonTags();

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
});


//TODO: start using the php files and delete this.
//	Luke put this stuff in header.php
function fillCommonTags() {
  $("header").first().load("header.html");
  $("nav").first().load("nav.html");
};

/* Protects your partially-filled custom order form.
 * Source: http://stackoverflow.com/questions/7317273/warn-user-before-leaving-page-with-unsaved-changes
 */
function closeEditorWarning() {
    return 'It looks like you have been editing something -- if you leave before submitting your changes will be lost.';
}
if (document.getElementById('ordering')) {
    window.onbeforeunload = closeEditorWarning;
}

function launchDialog() { 
    document.getElementById("paymentDialog").showModal(); 
}

var ticketItemCounter = 0;

//for menu burgers (index.html) and past orders
function updateTicket() {
    var selectedBurger = document.getElementsByClassName('burger_label');
    var burgerToAdd=selectedBurger[0].innerHTML;
    var entry = document.createElement('li');
    entry.appendChild(document.createTextNode(burgerToAdd));
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    createDeleteButton(entry);   
    createQuantityAdjuster(entry); 
    ticket.appendChild(entry);       
}

function removeTicketItem(itemId){
    var item = document.getElementById(itemId);
    ticket.removeChild(item);
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


function setSelected(event) {

}
