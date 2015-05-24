<div id="wrapper" class="clearFix container">

<?php
if(isset($info))
{
	echo '<p class=error_show>'.$info.'</p>';
}
?>


<form id="checkout" method="post" action="<?php echo ROOT.'order/checkout';?>" class="mainform">
	<fieldset>
		<legend>Please leave your detail here:</legend>
		<p>You must fill all fields with *.</p>
		<p>
			<label for="checkout_firstname">*First Name:</label>
			<input type="text" name="checkout_firstname" id="checkout_firstname" required pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="checkout_lastname">*Last Name:</label>
			<input type="text" name="checkout_lastname" id="checkout_lastname" required />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="checkout_address">*Address:</label>
			<input type="text" name="checkout_address" id="checkout_address" required pattern="[a-zA-Z0-9/ -]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="checkout_phone">*Contact Number:</label>
			<input type="text" name="checkout_phone" id="checkout_phone" />
			<span class="error">Please enter a valid australia phone number!</span>
		</p>
		<p>
			<label for="checkout_email">*Email:</label>
			<input type="email" name="checkout_email" id="checkout_email" required />
			<span class="error">Please enter a valid email address!</span>
		</p>
		<p>
			<label for="checkout_ccNo">*Credit Card No:</label>
			<input type="text" name="checkout_ccNo" id="checkout_ccNo" maxlength="16" pattern="[0-9]*">
		</p>
		<p>
			<label for="checkout_name">*Name on Card:</label>
			<input type="text" name="checkout_name" id="checkout_name">
		</p>
		<p>
			<label for="checkout_csv">*CSV</label>
			<input type="text" name="checkout_csv" id="checkout_csv" maxlength="3" pattern="[0-9]*">
		</p>
		<p>
			<label for="checkout_expire">*Expire:</label>
			<input type="month" name="checkout_expire" id="checkout_expire">
		</p>
		<p class="buttons">
			<button type="submit" name="checkoutButton" id="checkoutButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>


</div>