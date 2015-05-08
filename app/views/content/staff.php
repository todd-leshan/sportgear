<div id="wrapper" class="clearFix">

<h2 class="page-title">Welcome to Management System - Dear <?php echo $username; ?></h2>

<p class="staff-management-menu">You can:</p>

<ul class="staff-management-menu">
	<li><a href="<?php echo ROOT.'staff/manageProducts'; ?>">Browse all products</a></li>
	<li><a href="<?php echo ROOT.'staff/addProducts'; ?>">Add new products</a></li>
	<li><a href="<?php echo ROOT.'staff/changePassword'; ?>">Change Password</a></li>
	<li><a href="<?php echo ROOT.'staff/manageCategories'; ?>">Maintain Categories</a></li>
	<li><a href="<?php echo ROOT.'staff/customize'; ?>">Customize</a></li>
	<li><a href="#">Manage promotion lists</a></li>
	<li><a href="#">Manage Image Gallery</a></li>
</ul>

<p class="logout staff-management-menu"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>



</div>