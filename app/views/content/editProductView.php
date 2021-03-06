<div id="staff-wrapper" class="clearFix container">
<?php
if(isset($info))
{
	echo '<p class=error_show>'.$info.'</p>';
}
?>
<?php 

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

$status       = $product->getStatus;

?>	
<h4 id="product-page-category-menu">
	<a href="<?php echo ROOT; ?>">home</a> &gt; <a href="<?php echo ROOT.'product/'.$sportTypeName; ?>"><?php echo $sportTypeName; ?></a> &gt; <a href="<?php echo 'product/'.$sportTypeName.'/'.$gearTypeName; ?>"><?php echo $gearTypeName; ?></a>
</h4>	
	<article class="clearFix" id="product-detail">
	<!--need a place to store id-->
		<div  class="float-left product-image">
			<img src="/sportgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" width="240" height="320">
		</div>
		<div class="float-left product-detail">
			<h3><?php echo $name; ?></h3>
			<p>Price: $<?php echo $price; ?></p>
			<form class="addProduct">
				<p>
					<label for="qty">Qty:</label>
					<input type="number" name="qty" id="qty" required value="1">
					<span class="error">Please enter a valid quantity from 1 to 99!</span>
				</p>
				<p>
					<button type="submit" id="submitButton">Add to Cart</button>
				</p>
			</form>
		</div>
	</article>
	<p id="product-description"><?php echo str_replace("\n", "<br>", $description); ?></p>

</div>

