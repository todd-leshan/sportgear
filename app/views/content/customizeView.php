<div id="staff-wrapper" class="clearFix container">

<form method="post" action="<?php echo ROOT.'staff/customize'; ?>" novalidate>
	<fieldset>
		<legend>Background</legend>
		<label>
			<input type="radio" name="customize-bg" value="lemon.jpg">
			Lemon
		</label>
		<label>
			<input type="radio" name="customize-bg" value="wall.jpg">
			Wall
		</label>
		<label>
			<input type="radio" name="customize-bg" value="watermelon.gif">
			Watermelon
		</label>
		<label>
			<input type="radio" name="customize-bg" value="winter.jpg">
			Winter
		</label>
	</fieldset>

	<fieldset>
		<legend>Font Size</legend>
		<label>
			<input type="radio" name="customize-fs" value="small">
			Small
		</label>
		<label>
			<input type="radio" name="customize-fs" value="medium">
			Medium
		</label>
		<label>
			<input type="radio" name="customize-fs" value="large">
			Large
		</label>
	</fieldset>
	<button type="submit" name="customizeSave" id="customizeSave">Save</button>
</form>
<p class="goBack staff-management-menu"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout staff-management-menu"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>
</div>