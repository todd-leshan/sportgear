<div id="staff-wrapper" class="clearFix container">
<?php
if(isset($info))
{
	echo '<p class=error_show>'.$info.'</p>';
}
?>
<table>
	<tr>
		<th class="category-name">Name</th>
		<th class="category-status">Status</th>
		<th class="category-status">Update</th>
		<th class="category-status">Delete</th>
	</tr>
</table>
<?php 
foreach($gearTypes as $gear):
	$id     = $gear->getId();
	$name   = $gear->getName();
	$status = $gear->getStatus();
?>
<form method="post" class="manage-categories clearFix" action="<?php echo ROOT.'staff/manageCategories'; ?>">
	<input type="hidden" name="categoryID" value="<?php echo $id ;?>">

	<input type="text" name="category-name" class="category-name float-left" required value="<?php echo $name ;?>">

	<p class="category-status float-left">
		<label for="status-1">
			<input type="radio" name="category-status" value="1" <?php if($status == 1): echo 'checked'; endif;?>>
			active	
		</label>
		<label for="status-0">
			<input type="radio" name="category-status" value="0" <?php if($status == 0): echo 'checked'; endif;?>>
			inactive	
		</label>
	</p>

	<button type="submit" name="category-update" class="float-left">Update</button>
	<button type="submit" name="category-delete" class="float-left">Delete</button>
</form>
<?php
endforeach;

?>

<form class="mainform" method="post" action="<?php echo ROOT.'staff/manageCategories'; ?>">
	<fieldset>
		<legend>Add A New Category</legend>
		<p>
			<label>Category's Name:</label>
			<input type="text" name="category-name" required pattern="[a-zA-Z0-9_ /\.'-]*">
		</p>
		<p>
			<button type="submit" name="addCategorySubmit">Add</button>
		</p>
		

	</fieldset>
</form>

<p class="goBack staff-management-menu"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout staff-management-menu"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>