<?php
require_once __DIR__."/../core/DB.php";
require_once __DIR__."/../auth/register.php";
require_once __DIR__."/../core/CSRF.php";

$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['registerToken'],'registerToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
  $register = new Register();
	$register->createUser();
}
require_once __DIR__."/layouts/main.php";
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Create Account</h1>
<p class="form-subtitle">Join our community today</p>
</div>

<form action ="" method = "post">
  <?php echo $CSRF::getTokenField('registerToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>
  
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label required">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "email">
<?php if (isset($_SESSION['validationError']['email'])):?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['email']); ?></div>
<?php unset($_SESSION['validationError']['email']);?>
<?php endif ; ?>
  </div>
  
  <div class="form-group">
    <label for="exampleInputusername1" class="form-label required">Username</label>
    <input type="text" class="form-control" id="exampleInputUsername1" aria-describedby="emailHelp" name = "username">

<?php if (isset($_SESSION['validationError']['username'])):?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['username']); ?></div>
<?php unset($_SESSION['validationError']['username']);?>
<?php endif ; ?>
</div>

  <div class="form-group">
    <label for="exampleInputPassword1" class="form-label required">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
    <small class="form-text">Minimum 8 characters with letters and numbers</small>

<?php if (isset($_SESSION['validationError']['password'])):?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['password']); ?></div>
<?php unset($_SESSION['validationError']['password']);?>
<?php endif ; ?>
  </div>

<div class="form-group">
    <label for="exampleInputConfirmPassword1" class="form-label required">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputConfirmPassword1" name = "confirmPassword">
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">Register</button>
  <a href="<?=Root;?>/views/login.php" class="btn-secondary">Already have an account?</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/layouts/footer.php'; ?>