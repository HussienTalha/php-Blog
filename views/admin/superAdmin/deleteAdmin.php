<?php
require_once __DIR__.'/../../../admin/superAdmin.php';
require_once __DIR__."/../../../core/CSRF.php";

if (empty( $_SESSION['account'])  || ! $_SESSION['account']['superAdmin'])
{
	header('location:'.Root.'/views/home.php');

	exit;
}
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['deleteAdminToken'],'deleteAdminToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$superAdmin = new SuperAdmin;
	$state = $superAdmin-> deleteAdmin($_POST['username']);
	header('location: deleteAdmin.php');
	exit;
}
require_once __DIR__.'/../../layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Remove Admin</h1>
<p class="form-subtitle">Revoke administrator privileges</p>
</div>

<form method="post">

 <?php echo $CSRF::getTokenField('deleteAdminToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="alert alert-warning">
<strong>Warning:</strong> This action will remove administrator privileges from the selected user.
</div>

<div class="form-group">
<label for="delete-admin" class="required">Username</label>
<input type="text" name="username" class="form-control" placeholder="<?= htmlspecialchars($_GET['username'] ?? ''); ?>" value="<?= htmlspecialchars($_GET['username'] ?? ''); ?>">
<small class="form-text">Enter the username of the admin to remove</small>
</div>

<div class="form-actions">
<button type="submit" class="btn-danger">Remove Admin Privileges</button>
<a href="<?=Root?>/views/dashboard.php" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
