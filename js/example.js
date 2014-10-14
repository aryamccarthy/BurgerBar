function launchDialog() { 
    document.getElementById("paymentDialog").showModal(); 
} 

var ticket = document.getElementById('active_ticket');

function updateTicket() {
    var firstname = document.getElementsByClassName('burger_label');
    var burgerToAdd=firstname[0].innerHTML;
    var entry = document.createElement('li');
    entry.innerHTML=burgerToAdd;
    ticket.appendChild(entry);                                                          
 }