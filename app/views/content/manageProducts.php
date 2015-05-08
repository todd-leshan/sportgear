<div id="wrapper" class="clearFix">
<table>
	<tr class="manage-products-form-title">
		<th class="change-name">Product Name</th>
		<th class="change-price">Price</th>
		<th class="change-description">Description</th>
		<th class="change-image">Photo</th>
		<th class="change-brand">Brand</th>
		<th class="change-gearType">Category</th>
		<th class="sport-radio">Sport</th>
		<th class="status-radio">Status</th>
	</tr>
</table>
<?php 
foreach ($products as $product) :
	$productID     = $product->getId();
	$name          = $product->getName();
	$price         = $product->getPrice();
	$description   = $product->getDescription();
	
	$photo         = $product->getPhoto();
	$photoName     = $photo->getName();
	$photoAlt      = $photo->getAlt();
	
	$brand         = $product->getBrand();
	$brandName1    = $brand->getName();
	
	$gearType      = $product->getGearType();
	$gearTypeName1 = $gearType->getName();
	
	$sportType     = $product->getSportType();
	$sportTypeName1 = $sportType->getName();

	$status       = $product->getStatus();
?>	
	<form method="post" class="manage-products clearFix" action="<?php echo ROOT.'staff/manageProducts'; ?>">
	<input type="hidden" name="productID" value="<?php echo $productID ;?>">
		<p>
			<textarea name="change-name" class="change-name float-left" required><?php echo $name; ?></textarea>
		</p>
			
		<p>
			<input type="number" name="change-price" class="change-price float-left" required min="0" step="0.01" value="<?php echo $price; ?>">
		</p>
		<p>
			<textarea name="change-description" class="change-description float-left" required><?php echo $description; ?></textarea>
		</p>

		<p>
			<img src="/sportsgear/public/images/product/<?php echo $gearTypeName1.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" class='float-left change-image'>
		</p>

		<p>
			<select class="form-control change-brand float-left" name="change-brand" required size="9">
<?php
		foreach($brands as $brand):
			$brandID = $brand->getId();
			$brandName2 = $brand->getName();

			if($brandName2 == $brandName1):
?>
			<option value="<?php echo $brandID;?>" selected="selected"><?php echo $brandName2;?></option>				
<?php
			else:
?>
			<option value="<?php echo $brandID;?>"><?php echo $brandName2;?></option>
<?php
			endif;
		endforeach;
?>
			</select>
		</p>
		
		<p>
			<select class="form-control change-gearType float-left" name="change-gearType" required size="9">
<?php
		foreach($gearTypes as $gearType):
			$gearTypeID    = $gearType->getId();
			$gearTypeName2 = $gearType->getName();

			if($gearTypeName2 == $gearTypeName1):
?>
			<option value="<?php echo $gearTypeID;?>" selected="selected"><?php echo $gearTypeName2;?></option>			
<?php
			else:
?>
			<option value="<?php echo $gearTypeID;?>"><?php echo $gearTypeName2;?></option>	
<?php
			endif;
		endforeach;
?>
			</select>
		</p>

		<p class='float-left sport-radio'>
			<?php
	foreach($sportTypes as $sportType):
		$sportTypeID      = $sportType->getId();
		$sportTypeName2   = $sportType->getName();
		if($sportTypeName1 == $sportTypeName2):
?>	
			<label>
				<input type="radio" name="change-sport" class="change-sport" value="<?php echo $sportTypeID; ?>" checked>
				<?php echo $sportTypeName1; ?>
			</label>
<?php
		else:
?>
			<label>
				<input type="radio" name="change-sport" class="change-sport" value="<?php echo $sportTypeID; ?>">
				<?php echo $sportTypeName2; ?>
			</label>
<?php
		endif; 
	endforeach;
?>
		</p>
		
		<p class="float-left status-radio clearFix">
			<label for="status-1">
				<input type="radio" name="change-status" class="status" value="1" <?php if($status == 1): echo 'checked'; endif;?>>
				active	
			</label>
			<br>
			<label for="status-0">
				<input type="radio" name="change-status" class="status" value="0" <?php if($status == 0): echo 'checked'; endif;?>>
				inactive	
			</label>
		</p>
		
		<p>
			<button type="submit" name="change-update">Update</button>

			<button type="submit" name="change-delete">Delete</button>
		</p>
	</form>	
<?php
endforeach;
?>

<?php paginationLinks($pagination); ?>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>