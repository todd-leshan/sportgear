<div id="wrapper" class="clearFix">

<?php 
if(sizeof($itemsInCart) == 0)
{
	echo 'No items chosen yet!';
}
else
{
?>
<table>
<tr>
	<th>Name</th>
	<th>Price</th>
	<th>Brand</th>
	<th>Image</th>
	<th>Qty</th>
	<th>Total</th>
	<th>Action</th>
</tr>
<?php	
	foreach($itemsInCart as $item):
		$product = $item[0];
		$qty     = $item[1];

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
?>
<tr>
	<td><?php echo $name; ?></td>
	<td><?php echo $price; ?></td>
	<td><?php echo $brandName; ?></td>
	<td><img src="/sportsgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" width="120" height="180"></td>
	<td><?php echo $qty; ?></td>
	<td><?php echo $price*$qty; ?></td>
	<td>Comfirm</td>
</tr>
<?php
	endforeach;
}
?>
</table>

<p>Continue to Checkout</p>
</div>