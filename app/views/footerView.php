<div id="footer-container" class="clearfix  container-fluid">
	<footer class="container  clearfix center">
		<article id="payment_method" class="float-left">
			<h3>We Accept:</h3>
			<ul>
				<li><img src="/sportgear/public/images/payment/Visa.png" alt="visa" width="50" height="31" title="visa"></li>
				<li><img src="/sportgear/public/images/payment/Mastercard.png" alt="mastercard" width="50" height="31" title="mastercard"></li>
				<li><img src="/sportgear/public/images/payment/American-Express.png" alt="american express" width="50" height="31" title="amex"></li>
				<li><img src="/sportgear/public/images/payment/PayPal.png" alt="PayPal" width="50" height="31" title="paypal"></li>
			</ul>
		</article>
		<article id="brands" class="float-left">
			<h3>Brands</h3>
			<ul>
				<?php foreach($brands as $brand): ?>
				<li><a href="<?php echo ROOT.'product/brand/'.$brand->getName(); ?>" title="<?php echo strtoupper($brand->getName()); ?>"><?php echo strtoupper($brand->getName()); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</article>
		<article id="information" class="float-left">
			<h3>Information</h3>
			<ul>
				<li>Overview</li>
				<li>Copyright</li>
				<li>Privacy Policy</li>
				<li>Return Policy</li>
				<li>FAQs</li>
			</ul>
		</article>
		<article id="customer" class="float-left">
			<h3>Customer</h3>
			<ul>
				<li><a href="<?php echo ROOT.'contact'; ?>" title="Contact us">Contact us</a></li>
				<li><a href="" title="my account">My Account</a></li>
				<li><a href="" title="track my order">Track My Order</a></li>
			</ul>
		</article>
		<aside id="social-media">
			<ul>
				<li><a href=""><img src="/sportgear/public/images/social/Facebook.png" alt="facebook" width="48" height="48"></a></li>
				<li><a href=""><img src="/sportgear/public/images/social/Twitter2.png" alt="twitter" width="48" height="48"></a></li>
				<li><a href=""><img src="/sportgear/public/images/social/YouTube.png" alt="YouTube" width="48" height="48"></a></li>
				<li><a href=""><img src="/sportgear/public/images/social/Tumblr.png" alt="Tumblr" width="48" height="48"></a></li>
			</ul>
		</aside>
		<p id="copyright">Copyright Reserved <?php echo date("Y"); ?> Todd</p>
	</footer>
</div>
<script src="/sportgear/public/js/jquery-2.1.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="/sportgear/public/js/zoomIn.js"></script>

<script src="/sportgear/public/js/customize.js" type="text/javascript"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<!--
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;signed_in=true&amp;libraries=places"></script>
<script src="/sportgear/public/js/map.js"></script>
-->
</body>

</html>
