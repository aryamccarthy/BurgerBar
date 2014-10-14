<dialog id="paymentDialog">
	<form id=payment action="order-confirmation.html">
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
					<label for=provider>Provider</label>
				<select name="provider">
					<option value="visa">Visa</option>
					<option value="MasterCard">MasterCard</option>
					<option value="american_express" selected>American Express</option>
				</select>
				</li>

				<!-- TODO: credit card number needs to match this regex: http://www.regular-expressions.info/creditcard.html -->
				<li>
					<label for=credit_card>Credit card</label>
					<input id=credit_card name=credit_card type=tel placeholder="Credit card number" required>
				</li>
			</ol>
		</fieldset>
		
		<fieldset>
			<input type="submit" value="Place order">
		</fieldset>
	</form>
</dialog>