<?php
require_once __DIR__.'/../auth/login.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$login = new Login();
	$login->getUser();
}
?>
<html>
<head>
<title> login </title>
</head>
<body>
<?= require_once __DIR__.'/layouts/main.php';?>
<div class="mb-3">
<?php if (! empty($_SESSION['state'])): ?>
<p> <?= htmlspecialchars($_SESSION['state']); ?> </p>
<?php unset($_SESSION['state']); ?>
<?php endif ; ?>
</div>
<form action ="" method = "post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
<div class="mb-3">
<?php if (! empty($_SESSION['error'])):?>
<p> <?=  $_SESSION['error'];?> </p>
<?php unset($_SESSION['error']) ;?> 
<?php endif ;?>
</div>
</form>
</body>
</html>
