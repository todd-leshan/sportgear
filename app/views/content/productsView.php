<div id="wrapper" class="clearFix container">

<h4 id="product-page-category-menu">
<?php if($sport == 'tennis' || $sport == 'badminton'): ?>
	<a href="<?php echo ROOT; ?>">home</a> &gt; <a href="<?php echo ROOT.'product/'.$sport; ?>"><?php echo $sport; ?></a> 
<?php endif; ?>
</h4>

<section id="filter" class="float-left">

</section>

<section id="products-container" class="float-left clearFix">
<?php 
if(sizeof($products) > 0):
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

		if($status):
	?>	
		<article class="float-left clearFix">
		<!--need a place to store id-->
			<div>
				<a href="<?php echo ROOT.'product/product/'.$productID; ?>">
					<img src="/sportgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" width="180" height="240">
				</a>
			</div>
			<h4><?php echo $name; ?></h4>
			<p>$<?php echo $price; ?></p>
			<p><a href="<?php echo ROOT.'product/product/'.$productID; ?>">More Info</a></p>
		</article>
	<?php
		endif;
	endforeach;
	paginationLinks($pagination);

else:

	echo "No products found! Try again!";
endif;
?>

</section>

</div>