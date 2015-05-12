<div id="wrapper" class="clearFix">

<form id="contact" method="post" action="<?php echo ROOT;?>" class="mainform">
	<fieldset>
		<legend>Please leave your detail here:</legend>
		<p>You must fill all fields with *.</p>
		<p>
			<label for="contact_firstname">*First Name:</label>
			<input type="text" name="firstname" id="contact_firstname" required pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="contact_lastname">*Last Name:</label>
			<input type="text" name="lastname" id="contact_lastname" required />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="">*Address:</label>
			<input type="text" name="" id="" required pattern="[a-zA-Z0-9/-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="contact_phone">Contact Number:</label>
			<input type="text" name="phone" id="contact_phone" />
			<span class="error">Please enter a valid australia phone number!</span>
		</p>
		<p>
			<label for="contact_email">*Email:</label>
			<input type="email" name="email" id="contact_email" required />
			<span class="error">Please enter a valid email address!</span>
		</p>
		<p>
			<label>Credit Card No:</label>
			<input type="text" maxlength="16" pattern="[0-9]*">
		</p>
		<p>
			<label>Name on Card:</label>
			<input type="text">
		</p>
		<p>
			<label>CSV</label>
			<input type="number" max="999">
		</p>
		<p>
			<label>Expire:</label>
			<input type="month">
		</p>
		<p class="buttons">
			<button type="submit" id="submitButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>


</div>