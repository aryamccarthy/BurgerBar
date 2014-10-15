$(document).ready(function() {
	//TODO: Delete fillCommonTags(). See note below. -Luke
	fillCommonTags;

	var ticket = document.getElementById('active_ticket');

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

// TODO: fix this to show the contents of payment-from.php
function launchDialog() { 
    
}

var ticketItemCounter = 0;


//for menu burgers (index.html) and past orders
function updateTicket() {
    var selectedBurger = document.getElementsByClassName('burger_label');
    var burgerToAdd=selectedBurger[0].innerHTML;
    var entry = document.createElement('li');
    entry.appendChild(document.createTextNode(burgerToAdd));
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    var deleteButton = document.createElement('button');
    deleteButton.appendChild(document.createTextNode("Delete"));
    deleteButton.setAttribute('onClick','removeTicketItem("'+'ticketItem'+ticketItemCounter+'")');
    entry.appendChild(deleteButton);
    ticketItemCounter+=1;
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
    entry.innerHTML=(patty + "\n" + bun + "\n" + cheese + "\n" + toppingsList + "\n" + sauceList + "\n" +sideList );
    //entry.innerHTML=("A "+patty+"  patty on a "+bun+" bun with "+cheese+" cheese, topped with "+toppingsList+" "+sauceList+" with a side of "+sideList+" ");
    entry.setAttribute('id','ticketItem'+ticketItemCounter);
    var deleteButton = document.createElement('button');
    deleteButton.appendChild(document.createTextNode("Delete"));
    deleteButton.setAttribute('onClick','removeTicketItem("'+'ticketItem'+ticketItemCounter+'")');
    entry.appendChild(deleteButton);
    ticketItemCounter+=1;
    ticket.appendChild(entry);
    ticket.appendChild(entry);                                                          
}
