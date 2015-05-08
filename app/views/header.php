<!DOCTYPE html>
<html>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="/sportsgear/public/css/sportgear.css">	

	<!-- staff customize-->
	<link rel="stylesheet" type="text/css" href="/sportsgear/public/css/staff.css">	
	<link rel="stylesheet" type="text/css" href="/sportsgear/public/css/lemon.css">	
</head>
<?php require_once(__DIR__ . "/../core/global.php"); ?>
<body>
<div id="top-menu-container">
	<nav id="top-menu">
		<ul>
			<li><a href="<?php echo ROOT; ?>">Welcome to SportGear!</a></li>
			<?php foreach($sportTypes as $sportType): ?>
			<li>
				<a href="<?php echo ROOT.'product/'.$sportType->getName(); ?>">
					<?php echo strtoupper($sportType->getName()); ?>
				</a>
				<ul>
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

		<ul class="float-right">
			<li><a href="<?php echo ROOT.'user/signUp'; ?>">Join us</a></li>
			<li><a href="<?php echo ROOT.'user'; ?>">Sign In</a></li>
			<li id="shoppingcart"><a href="">Shoppig Cart(0)</a></li>
		</ul>
	</nav>
</div>

<header class="clearFix">
	<h1><a href="<?php echo ROOT; ?>">SportGear</a></h1>
	<section id="search">
		<form action="<?php echo ROOT.'product/search'; ?>" method="post">
			<input type="search" id="site-search" name="site-search" placeholder="Search SportGear" />
			<button class="close-icon" type="reset"></button>
			<button type="submit" id="searchButton">Go</button>
		</form>
	</section>		
	<time id="clock" datetime="2008-02-14 20:00">Now</time>

</header>