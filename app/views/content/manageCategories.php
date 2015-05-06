<div id="wrapper" class="clearFix">

<table id="manage-categories">
	<tr>
		<th>Name</th>
		<th>Status</th>
		<th>Update</th>
		<th>Delete</th>
	</tr>

<?php 
foreach($gearTypes as $gear)
{
	$id     = $gear->getId();
	$name   = $gear->getName();
	$status = $gear->getStatus();
?>
	<tr>
		<form method="post" class="manage-categories">
		<input type="hidden" name="categoryID" value="<?php echo $id ;?>">
		<td>
			<input type="text" name="category-name" required value="<?php echo $name ;?>">
		</td>
		<td>
			<label for="status-1">
				<input type="radio" name="category-status" class="status" value="1" <?php if($status == 1): echo 'checked'; endif;?>>
				active	
			</label>
			<label for="status-0">
				<input type="radio" name="category-status" class="status" value="0" <?php if($status == 0): echo 'checked'; endif;?>>
				inactive	
			</label>
		</td>
		<td>
			<button type="submit" name="category-update">Update</button>
		</td>
		<td>
			<button type="submit" name="category-delete">Delete</button>
		</td>
		</form>
	</tr>
<?php
}

?>

</table>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>