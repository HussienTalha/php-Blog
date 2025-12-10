<?php
if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__."/../../core/config.php";

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Custom CSS -->
    <link href="<?=Root;?>/public/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
	<a class="nav-link active" aria-current="page" href="<?=Root;?>">Home</a>
        </li>
<?php if( isset ($_SESSION['account'])):?>
	<li class="nav-item">
	<a class="nav-link active" href="<?=Root?>/views/profile.php">Profile</a>
	</li>
	<li class=nav-item">
<?php endif;?>
	<a class="nav-link active" href="<?=Root?>/views/categories.php">Categories</a>
	</li>
<?php if(isset ($_SESSION['account']['admin'])):?>
	<li class=nav-item">
	<a class="nav-link active" href="<?=Root?>/views/dashboard.php">Dashboard</a>
	</li>
<?php endif;?>
      </ul>
	<ul class="navbar-nav">	
<?php if(! isset ($_SESSION['account'])):?>
        <li class="nav-item">
	<a class="nav-link active" href="<?=Root?>/views/register.php">Register</a>
	</li>
        <li class="nav-item">
	<a class="nav-link active" href="<?=Root?>/views/login.php">Login</a>
        </li>
<?php else :?>
	</li>
	<li class="nav-item">
	<a class="nav-link active" href="<?=Root?>/auth/logout.php">Logout</a>
<?php endif;?>
	</li>

	</ul>
    </div>
  </div>
  </nav>
  
<div class="container">
