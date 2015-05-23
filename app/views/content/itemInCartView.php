<div id="wrapper" class="clearFix">

<?php
if($info)
{
	echo '<p class=error_show>'.$info.'</p>';
}

if(sizeof($itemsInCart) == 0)
{
	echo 'No items chosen yet!';
}
else
{
?>
<table id="shoppingcart">
<tr>
	<th>Name</th>
	<th>Price</th>
	<th>Brand</th>
	<th>Image</th>
	<th>Qty</th>
	<th>Total</th>
</tr>
<?php
	$cartTotal = 0;

	foreach($itemsInCart as $item):
		$product = $item[0];
		$qty     = $item[1];

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
?>
<tr>
	<td><?php echo $name; ?></td>
	<td><?php echo $price; ?></td>
	<td><?php echo $brandName; ?></td>
	<td><img src="/sportgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" height="240"></td>
	<td>
		<form method="post" action="<?php echo ROOT.'order/updateCart'; ?>">
			<input type="hidden" name="productID" value="<?php echo $productID; ?>">
			<input type="number" name="updateItem-qty" required value="<?php echo $qty; ?>">
			<br>
			<button type="submit" name="updateItem">Update</button>
			
			<button type="submit" name="deleteItem">Delete</button>
		</form>
	</td>
	<td>
		<?php echo $price*$qty; ?>
		<?php $cartTotal += $price*$qty; ?>
	</td>
</tr>
<?php
	endforeach;
?>
</table>

<p id="cartTotal">Total:$<?php echo $cartTotal; ?></p>

<p id="checkoutLink"><a href="<?php echo ROOT.'order/checkout'; ?>">Continue to Checkout</a></p>
<?php
}
?>

</div>