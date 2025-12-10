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
  $state = $CSRF->validateToken($_POST['deleteUserToken'],'deleteUserToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }

	$admin = new Users;
	$state = $admin->deleteUser($_POST['username']);
	$_SESSION['deleteUser-state'] = $state;
	$username = $_GET['username']?? "";
	header('location: deleteUser.php');
	return;

}
require_once __DIR__.'/../layouts/main.php';

?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Delete User</h1>
<p class="form-subtitle">Permanently remove user account</p>
</div>

<?php if (isset($_SESSION['deleteUser-state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['deleteUser-state']); ?></div>
<?php unset($_SESSION['deleteUser-state']);?>
<?php endif ; ?>

<form method="post">

 <?php echo $CSRF::getTokenField('deleteUserToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="alert alert-danger">
<strong>Danger:</strong> This action cannot be undone. All posts and data associated with this user will be permanently deleted.
</div>

<div class="form-group">
<label for="username" class="required">Username</label>
<input type="text" name="username" class="form-control" placeholder="<?= htmlspecialchars($_GET['username'] ?? ''); ?>" value="<?= htmlspecialchars($_GET['username'] ?? ''); ?>">
<small class="form-text">Confirm the username to delete</small>
</div>

<div class="form-group">
<div class="form-check">
<input class="form-check-input" type="checkbox" id="confirmDelete" required>
<label class="form-check-label" for="confirmDelete">
I understand that this action is irreversible
</label>
</div>
</div>

<div class="form-actions">
<button type="submit" class="btn-danger">Delete User Permanently</button>
<a href="<?=Root?>/views/dashboard.php" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>