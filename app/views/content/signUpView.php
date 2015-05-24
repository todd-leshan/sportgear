<div id="wrapper" class="clearFix container">
<form id="signup" method="post" action="<?php echo ROOT.'user/signUpProcess'; ?>" class="mainform">
	<fieldset>
	<legend>Sign up to get member special!</legend>

<?php
if(isset($info))
{
	echo '<p class=error_show>'.$info.'</p>';
}
?>	
		<p>You must fill all fields with *.</p>
		<p>
			<label for="signup-username">*Username:</label>
			<input type="text" name="username" id="signup-username" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="signup-password1">*Password:</label>
			<input type="password" name="password1" id="signup-password1" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="signup-password2">*Confirm:</label>
			<input type="password" name="password2" id="signup-password2" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<!--<span class="error">This field is required!</span>-->
			<span class="error">Passwords must be the same!</span>
		</p>
		<p>
			<label for="signup-email">*Email:</label>
			<input type="email" name="email" id="signup-email" required />
			<span class="error">Please enter a valid email address!</span>
		</p>

		<p class="buttons">
			<button type="submit" id="signupButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>

</div>


