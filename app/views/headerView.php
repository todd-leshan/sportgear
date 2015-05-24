<!DOCTYPE html>
<html>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick-theme.css"/>
	<!--
	<link rel="stylesheet" type="text/css" href="/sportgear/public/css/sportgear.css">	
	-->
	<link rel="stylesheet" type="text/css" href="/sportgear/public/css/newStyle.css">
<?php 
if(isset($user))
{
	if($user == 'staff' && isset($_SESSION['staff']))
	{
		$css = 'staff'.$_SESSION['staff']['staffID'].'.css';
		if($css)
		{
		?>
			<link rel="stylesheet" type="text/css" href="/sportgear/public/css/<?php echo $css; ?>">
		<?php	
		}
	}
}


?>
	
</head>
<?php require_once(__DIR__ . "/../core/global.php"); ?>
<body>

<header class="clearFix container-fluid">
	<ul id="top-menu-right" class="centre container clearFix">
			<li id="shoppingcart"><a href="<?php echo ROOT.'order/showCart'; ?>">
			<?php 
			if(isset($_SESSION['cart']))
			{
				$items = sizeof($_SESSION['cart']);
			}
			else
			{
				$items = 0;
			}
			?>
			<img src="/sportgear/public/images/cart.jpg" width="20" height="20">Shoppig Cart(<?php echo $items; ?>)</a></li>
			<li><a href="<?php echo ROOT.'user/signUp'; ?>">&nbsp;Join us&nbsp;</a></li>
			<li><a href="<?php echo ROOT.'user'; ?>">&nbsp;Sign In&nbsp;</a></li>
	</ul>
	
	<div class="centre container clearFix" id="header-search-time">
		<h1 class="col-lg-4 col-md-4 col-xs-4 col-sm-12"><a href="<?php echo ROOT; ?>">SportGear</a></h1>
		<section class="col-lg-4 col-md-4 col-xs-4 col-sm-12">
			
		</section>		
		<time id="clock" class="col-lg-4 col-md-4 col-xs-4 col-sm-12" datetime="2008-02-14 20:00">Now</time>
	</div>
<div class="header-row2 container">
	<nav id="top-menu" class="container clearFix centre col-lg-8 col-md-8 col-xs-8 col-sm-12">
		<ul id="top-menu-left">
			<li><a href="<?php echo ROOT; ?>">HOME</a></li>
			<?php foreach($sportTypes as $sportType): ?>
			<li>
				<a href="<?php echo ROOT.'product/'.$sportType->getName(); ?>">
					<?php echo strtoupper($sportType->getName()); ?>
				</a>
				<ul class="hover-menu">
				<?php foreach($gearTypes as $gear): 
						if($gear->getStatus()):
				?>
					<li>
						<a href="<?php echo ROOT.'product/'.$sportType->getName().'/'.$gear->getName(); ?>">
						<?php echo  strtoupper($gear->getName()); ?>
						</a>
					</li>
				<?php 
						endif;
					endforeach; 
				?>
				</ul>
			</li>
		<?php endforeach; ?>
				
		</ul>	
	</nav>
	<form id="site-search" class="col-lg-4 col-md-4 col-xs-4 col-sm-12" action="<?php echo ROOT.'product/search'; ?>" method="post">
		<input type="search" id="site-search" name="site-search" placeholder="Search SportGear" />
		<button class="close-icon" type="reset"></button>
		<button type="submit" id="searchButton">Go</button>
	</form>
</div>
</header>