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
<<<<<<< HEAD
};

/* Protects your partially-filled custom order form.
 * Source: http://stackoverflow.com/questions/7317273/warn-user-before-leaving-page-with-unsaved-changes
 */
function closeEditorWarning() {
    return 'It looks like you have been editing something -- if you leave before submitting your changes will be lost.';
}
if (document.getElementById('ordering')) {
    window.onbeforeunload = closeEditorWarning;
=======
>>>>>>> FETCH_HEAD
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