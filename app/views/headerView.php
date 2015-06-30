<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick-theme.css"/>

	<link rel="stylesheet" type="text/css" href="/sportgear/public/css/style.css">
	<link rel="stylesheet" type="text/css" href="/sportgear/public/css/sportgear.css">
<?php
if(isset($user))
{
	if($user == 'staff' && isset($_SESSION['staff']))
	{
		$css = 'staff'.$_SESSION['staff']['staffID'].'.css?'.rand();
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

<<<<<<< HEAD
<header class="container-fluid clearfix">
	<div class="container centre">
		<h1 class="col-xs-12 col-md-6">
			<a href="<?php echo ROOT; ?>">Sport<span class="rotate">G</span>ear</a>
		</h1>
		<div id="top-menu-right" class="col-xs-12 col-md-6">
				<a href="<?php echo ROOT.'user/signUp'; ?>" id="signUp_link" class="col-xs-4 col-md-2 col-md-push-5">Join us</a>
				<a href="<?php echo ROOT.'user'; ?>" id="signIn_link" class="col-xs-4 col-md-2 col-md-push-5">Sign In</a>
				<a href="<?php echo ROOT.'order/showCart'; ?>" id="shoppingCart" class="col-xs-4 col-md-3 col-md-push-5">
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
				View Cart(<?php echo $items; ?>)
				</a>
		</div>
=======
<header class="clearFix container-fluid">
	<ul id="top-menu-right" class="centre clearFix">
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
			Shoppig Cart(<?php echo $items; ?>)</a></li>
			<!--
			<li><a href="<?php echo ROOT.'user/signUp'; ?>">&nbsp;Join us&nbsp;</a></li>
			<li><a href="<?php echo ROOT.'user'; ?>">&nbsp;Sign In&nbsp;</a></li>
			-->
	</ul>
	
	<div class="centre clearFix" id="header">
		<h1><a href="<?php echo ROOT; ?>"><span class="float-left">Sport</span><span class="float-left rotate">G</span><span class="float-left">ear</span></a></h1>

>>>>>>> origin/master
	</div>

	<div class="container centre clearfix">
		<form id="site-search-form" class="navbar-form navbar-left col-xs-12 col-md-3 col-md-push-6 no-padding no-margin" role="search" method="post" action="<?php echo ROOT.'product/search'; ?>">
			<div class="form-group col-xs-9 no-padding">
				<input type="search" class="form-control no-padding" id="site-search" name="site-search" placeholder="Search SportGear">
			</div>
			<div class="form-group no-padding">
				<div class="col-xs-3 no-padding">
					<button type="submit" class="btn btn-default">Go</button>
				</div>
			</div>
		</form>
		<nav id="top-menu" class="col-xs-12 col-md-6 col-md-pull-3">
			<ul id="top-menu-left">
				<li class="float-left col-xs-4 col-md-2 menu-level-one no-padding"><a href="<?php echo ROOT; ?>">HOME</a></li>
				<?php foreach($sportTypes as $sportType): ?>
				<li class="float-left col-xs-4 col-md-3 menu-level-one no-padding">
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

		<!-- <form id="site-search" class="col-xs-12 col-md-3" action="<?php echo ROOT.'product/search'; ?>" method="post">
			<input type="search" id="site-search" name="site-search" placeholder="Search SportGear" /><button class="close-icon" type="reset"></button><button type="submit" id="searchButton">Go</button>
		</form> -->

		<time id="clock" class="col-md-3 hidden-xs" width="180" datetime="2008-02-14 20:00">Now</time>
	</div>
</header>
