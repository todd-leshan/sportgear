
<div id="wrapper" class="clearFix">

<table>
	<tr>
		<th class="productName">Name</th>
		<th class="productPrice">Price</th>
		<th class="productDesc">Description</th>
		<th class="productPhoto">Photo</th>
		<th class="productbrand">Brand</th>
		<th class="productCate1">Category</th>
		<th class="productCate2">Sport</th>
		<th>Status</th>
		<th></th>
	</tr>
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
	<tr>
		<form method="post" class="manage-products">
		<input type="hidden" name="productID" value="<?php echo $productID ;?>">
			<td>
				<textarea name="change-name" class="change-name" required><?php echo $name; ?></textarea>
			</td>
			<td>
				<input type="number" name="change-price" class="change-price" required min="0" step="0.01" value="<?php echo $price; ?>">
			</td>
			<td  class="productDesc">
				<textarea name="change-description" class="change-description" required><?php echo $description; ?></textarea>
			</td>
			<td><img src="/sportsgear/public/images/product/<?php echo $gearTypeName1.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>"></td>
			
			<td>
				<select class="form-control change-brand" name="change-brand" required size="10">
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
			</td>

			<td>
				<select class="form-control change-gearType" name="change-gearType" required size="10">
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
			</td> 

			<td>
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
			</td>
			<td>		
				<label for="status-1">
					<input type="radio" name="change-status" class="status" value="1" <?php if($status == 1): echo 'checked'; endif;?>>
					active	
				</label>
				<br>
				<label for="status-0">
					<input type="radio" name="change-status" class="status" value="0" <?php if($status == 0): echo 'checked'; endif;?>>
					inactive	
				</label>
			</td>
			<td>
				<button type="submit" name="change-update">Update</button>
				<br>
				<button type="submit" name="change-delete">Delete</button>
			</td>
		</form>
	</tr>
<?php
endforeach;
?>
</table>
<?php paginationLinks($pagination); ?>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>