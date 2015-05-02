<?php 
if($redirect)
{
	header("Refresh:5; url=".ROOT."staff/signOut");
}
?>
<div id="wrapper" class="clearFix">
<form id="signin" method="post" action="<?php echo ROOT.$user.'/changePassword'; ?>" class="mainform">
	<fieldset>
	<legend>Fill all fields:</legend>
<?php
	if($info)
	{
?>
	<p class="info"><?php echo $info; ?></p>
<?php		
	}
?>
		<p>
			<label for="change-password1">Old Password:</label>
			<input type="password" name="change-password1" id="change-password1" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="change-password2">New Password:</label>
			<input type="password" name="change-password2" id="change-password2" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="change-password3">Confirm:</label>
			<input type="password" name="change-password3" id="change-password3" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>

		<p class="buttons">
			<button type="submit" id="changePasswordButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>


