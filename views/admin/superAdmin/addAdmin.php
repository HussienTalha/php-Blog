<?php
require_once __DIR__.'/../../../admin/superAdmin.php';
require_once __DIR__.'/../../../admin/users.php';
require_once __DIR__."/../../../core/CSRF.php";


if (empty( $_SESSION['account'])  || ! $_SESSION['account']['superAdmin'])
{
	header('location:'.Root.'views/home.php');
	exit;
}
$getUsers = new Users;
$users = $getUsers->getUsers();
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['addAdminToken'],'addAdminToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$superAdmin = new SuperAdmin;
	$state = $superAdmin-> addAdmin($_POST['username']);
	$_SESSION['addAdmin-state'] = $state;
	header('location: addAdmin.php');
	exit;
}
require_once __DIR__.'/../../layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Add Admin</h1>
<p class="form-subtitle">Grant administrator privileges to a user</p>
</div>

<?php if (isset($_SESSION['addAdmin-state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['addAdmin-state']); ?></div>
<?php endif;
unset($_SESSION['addAdmin-state']);
?>

<form method="post">
 <?php echo $CSRF::getTokenField('addAdminToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for="add-admin" class="required">Select User</label>
<select name="username" class="form-control">
<option value="">-- Select a user --</option>
<?php foreach($users as $user): ?>
<?php if (! isset($user['admin'])): ?>
<option value="<?= htmlspecialchars($user['username']); ?>"><?= htmlspecialchars($user['username']); ?> (<?= htmlspecialchars($user['email']); ?>)</option>
<?php endif; ?>
<?php endforeach; ?>
</select>
<small class="form-text">Only non-admin users are shown</small>
</div>

<div class="form-actions">
<button type="submit" class="btn-success">Promote to Admin</button>
<a href="<?=Root?>/views/dashboard.php" class="btn-secondary">Back to Dashboard</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
