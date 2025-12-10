<?php

require_once __DIR__.'/../../admin/users.php';
require_once __DIR__."/../../core/CSRF.php";


if (empty( $_SESSION['account'])  || ! isset($_SESSION['account']['admin']))
{
	header('location: ../categories.php');

	return;
}
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['createUserToken'],'createUserToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }

	$admin = new Users;
	$state = $admin->createUser();
	$_SESSION['createUser-state'] = $state;	
	header('location: createUser.php');
	return;
}

require_once __DIR__.'/../layouts/main.php';


?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Create New User</h1>
<p class="form-subtitle">Add a new user to the system</p>
</div>

<?php  if (isset($_SESSION['createUser-state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['createUser-state']); ?></div>
<?php unset($_SESSION['createUser-state']);?>
<?php endif ; ?>

<form method="post">
 <?php echo $CSRF::getTokenField('createUserToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for="username" class="required">Username</label>
<input type="text" name="username" class="form-control" placeholder="Enter username">
<?php  if (isset($_SESSION['validationError']['username'])): ?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['username']); ?></div>
<?php unset($_SESSION['validationError']['username']);?>
<?php endif ; ?>
</div>

<div class="form-group">
<label for="email" class="required">Email Address</label>
<input type="email" name="email" class="form-control" placeholder="Enter email address">
<?php if (isset($_SESSION['validationError']['email'])):?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['email']); ?></div>
<?php unset($_SESSION['validationError']['email']);?>
<?php endif ; ?>
</div>

<div class="form-group">
<label for="password" class="required">Set Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter password">
<?php if (isset($_SESSION['validationError']['password'])):?>
<div class="invalid-feedback"><?= htmlspecialchars($_SESSION['validationError']['password']); ?></div>
<?php unset($_SESSION['validationError']['password']);?>
<?php endif ; ?>
</div>

<?php if ($_SESSION['account']['superAdmin']): ?>
<div class="form-group">
<label for="confirmPassword" class="required">Confirm Password</label>
<input type="password" name="confirmPassword" class="form-control" placeholder="Confirm password">
</div>

<div class="form-group">
<label>Admin Privileges</label>
<div class="form-check">
<input class="form-check-input" type="radio" name="admin" id="adminYes" value="1">
<label class="form-check-label" for="adminYes">
Yes - Grant admin access
</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="admin" id="adminNo" value="0" checked>
<label class="form-check-label" for="adminNo">
No - Regular user access
</label>
</div>
</div>
<?php endif;?>

<div class="form-actions">
<button type="submit" class="btn-success">Add User</button>
<a href="<?=Root?>/views/dashboard.php" class="btn-secondary">Back to Dashboard</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>

