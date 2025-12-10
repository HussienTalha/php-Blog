<?php
require_once __DIR__.'/../auth/login.php';
require_once __DIR__."/../core/CSRF.php";

$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['loginToken'],'loginToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$login = new Login();
	$login->getUser();
}
require_once __DIR__.'/layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Welcome Back</h1>
<p class="form-subtitle">Sign in to your account</p>
</div>

<div class="mb-3">
<?php if (! empty($_SESSION['state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['state']); ?></div>
<?php unset($_SESSION['state']); ?>
<?php endif ; ?>
</div>

<form action ="" method = "post">
  
 <?php echo $CSRF::getTokenField('loginToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>
  
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label required">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "email">
  </div>
  
  <div class="form-group">
    <label for="exampleInputPassword1" class="form-label required">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
    <small class="form-text"><a href="#" class="text-primary">Forgot password?</a></small>
  </div>
  
<div class="form-group">
<?php if (! empty($_SESSION['error'])):?>
<div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
<?php unset($_SESSION['error']) ;?> 
<?php endif ;?>
</div>

<div class="form-actions">
  <button type="submit" class="btn-primary">Login</button>
  <a href="<?=Root;?>/views/register.php" class="btn-secondary">Create Account</a>
</div>

<div class="text-center mt-4">
<p class="text-muted">Don't have an account? <a href="<?=Root;?>/views/register.php" class="text-primary">Sign up here</a></p>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/layouts/footer.php'; ?>