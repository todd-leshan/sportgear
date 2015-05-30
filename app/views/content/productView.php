<div id="wrapper" class="clearFix container">
<section>
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
				<form class="addProduct" method="post" action="<?php echo ROOT.'order/addToCart'; ?>">
					<p>
						<label for="qty">Qty:</label>
						<input type="hidden" name="productID" value="<?php echo $productID; ?>">
						<input type="number" name="qty" id="qty" required value="1" min="1">
						<span class="error">Please enter a valid quantity from 1 to 99!</span>
					</p>
					<p>
						<button type="submit" id="addToCartButton">Add to Cart</button>
					</p>
				</form>
			</div>
		</article>
		<p id="product-description">
		<?php  
			if($description)
			{
				echo str_replace("\n", "<br>", $description);
			}
			else
			{
				echo 'Detailed information will be added later!';
			}
		?>
		</p>
</section>

<section id="category" class="clearFix">
  	<a href="<?php echo ROOT.'product/category/racquet'; ?>">
      <article class="category category_racquet">
    		<h2>Racquet</h2>
    	</article>
    </a>
    <a href="<?php echo ROOT.'product/category/ball'; ?>">
    	<article class="category category_ball">
    		<h2>Ball</h2>
    	</article>
    </a>
    <a href="<?php echo ROOT.'product/category/footwear'; ?>">
    	<article class="category category_footwear">
    		<h2>Footwear</h2>
    	</article>
    </a>
    <a href="<?php echo ROOT.'product/category/clothing'; ?>">
    	<article class="category category_clothing">
    		<h2>Clothing</h2>
    	</article>
    </a>
    <a href="<?php echo ROOT.'product/category/accesory'; ?>">
    	<article class="category category_accessory">
    		<h2>Accessory</h2>
    	</article>
    </a>
</section>

</div>

