
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
	$productID    = $product->getId();
	$name         = $product->getName();
	$price        = $product->getPrice();
	$description  = $product->getDescription();
	
	$photo        = $product->getPhoto();
	$photoName    = $photo->getName();
	$photoAlt     = $photo->getAlt();
	
	$brand        = $product->getBrand();
	$brandName    = $brand->getName();
	
	$gearType     = $product->getGearType();
	$gearTypeName = $gearType->getName();
	
	$sportType    = $product->getSportType();
	$sportTypeName= $sportType->getName();

	$status       = $product->getStatus();
?>	
	<tr>
		<form method="post">
			<td><?php echo $name; ?></td>
			<td>
				<input type="number" name="change-price" id="change-price" required min="0" step="0.01" value="<?php echo $price; ?>">
			</td>
			<td  class="productDesc">
				<textarea name="change-description" id="change-description" required><?php echo $description; ?></textarea>
			</td>
			<td><img src="/sportsgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>"></td>
			<td><?php echo $brandName; ?></td>
			<td><?php echo $gearTypeName; ?></td>
			<td><?php echo $sportTypeName; ?></td>
			<td>
			
				<label for="status-1">
					<input type="radio" name="change-status" id="status-1" value="<?php echo $status;?>" <?php if($status == 1): echo 'checked'; endif;?>>
					active	
				</label>
				<br>
				<label for="status-0">
					<input type="radio" name="change-status" id="status-0" value="0" <?php if($status == 0): echo 'checked'; endif;?>>
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