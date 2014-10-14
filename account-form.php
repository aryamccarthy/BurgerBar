<?php
$pageTitle = "Burger Bar: Create Account";
include('include/header.php');
?>
<form id=login action= "index.html">
	<fieldset>
		<legend>Your details</legend>
		<ol>
			<li>
				<label for=first_name>First name</label>
				<input id=first_name name=first_name type=text placeholder="First name" required autofocus>
			</li>
			<li>
				<label for=last_name>Last name</label>
				<input id=last_name name=last_name type=text placeholder="Last name" required>
			</li>
			<li>
				<label for=email>Email</label>
				<input id=email name=email type=email placeholder="example@domain.com" required>
			</li>
			<li>
				<label for=password>Password (8 or more characters)</label>
				<input id=password name=password type=password pattern=".{8,}" placeholder="Password" required>
			</li>
			<li>
				<label for=provider>Provider</label>
			<select name="provider" id="provider">
				<option value="visa">Visa</option>
				<option value="MasterCard">MasterCard</option>
				<option value="american_express" selected>American Express</option>
			</select>
			</li>

			<li>
				<label for=credit_card>Credit card</label>
				<input id=credit_card name=credit_card type=text placeholder="Credit card number" pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$" required>
				<!--Regex c/o http://www.regular-expressions.info/creditcard.html-->
			</li>
		</ol>
	</fieldset>  
    <input type="submit" value="Create an account">
</form>

<?php
include('include/footer.php');
?>