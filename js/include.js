$(document).ready(function() {
	//TODO: Delete fillCommonTags(). See note below. -Luke
	fillCommonTags():

	var ticket = document.getElementById('active_ticket');
}

//TODO: start using the php files and delete this.
//	Luke put this stuff in header.php
function fillCommonTags() {
  $("header").first().load("header.html");
  $("nav").first().load("nav.html");
}

// TODO: fix this to show the contents of payment-from.php
function launchDialog() { 
    
}

function updateTicket() {
    var firstname = document.getElementsByClassName('burger_label');
    var burgerToAdd=firstname[0].innerHTML;
    var entry = document.createElement('li');
    entry.innerHTML=burgerToAdd;
    ticket.appendChild(entry);                                                          
 }