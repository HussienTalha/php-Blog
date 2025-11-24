<?php
require_once __DIR__."/../core/DB.php";
require_once __DIR__."/../auth/register.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$register = new Register();
	$register->createUser();
}
require_once __DIR__."/layouts/main.php";
?>
<html>
<head>
<title> Register </title>
</head>
<body>
<form action ="" method = "post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "email">
<?php if (isset($_SESSION['validationError']['email'])):?>
<p> <?= $_SESSION['validationError']['email']; ?> </p>
<?php unset($_SESSION['validationError']['email']);?>
<?php endif ; ?>
  </div>
  <div class="mb-3">
    <label for="exampleInputusername1" class="form-label">Username</label>
    <input type="text" class="form-control" id="exampleInputUsername1" aria-describedby="emailHelp" name = "username">
<?php if (isset($_SESSION['validationError']['username'])):?>
<p> <?= $_SESSION['validationError']['username']; ?> </p>
<?php unset($_SESSION['validationError']['username']);?>
<?php endif ; ?>
</div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
<?php if (isset($_SESSION['validationError']['password'])):?>
<p> <?= $_SESSION['validationError']['password']; ?> </p>
<?php unset($_SESSION['validationError']['password']);?>
<?php endif ; ?>
  </div>
<div class="mb-3">
    <label for="exampleInputConfirmPassword1" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputConfirmPassword1" name = "confirmPassword">
<?php if (isset($_SESSION['validationError']['password'])):?>
<p> <?= $_SESSION['validationError']['password']; ?> </p>
<?php unset($_SESSION['validationError']['password']);?>
<?php endif ; ?>
  </div>
<div>
  <button type="submit" class="btn btn-primary">Register</button>
</div>
</form>
</body>
</html>
