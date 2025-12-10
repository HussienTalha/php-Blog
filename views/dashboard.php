<?php
require_once __DIR__.'/../admin/users.php';
require_once __DIR__.'/../admin/superAdmin.php';
if (empty($_SESSION['account']) ||! $_SESSION['account']['admin'])
{

	header('location: home.php');
	exit;
}

$dashboard = new Users;
$admins = $dashboard->getAdmins();
$users = $dashboard->getUsers();
require_once __DIR__.'/layouts/main.php';
?>


<div class="dashboard-page">
<div class="dashboard-header text-center mb-5">
<h1>Admin Dashboard</h1>
<p class="lead">Manage users and system settings</p>
</div>

<div class="dashboard-buttons mb-4">
<div class="row">
<div class="col-md-4 mb-3">
<a href="<?=Root?>/views/admin/createUser.php" class="btn btn-success w-100 py-3">Create New User</a>
</div>
<?php if ($_SESSION['account']['superAdmin']): ?>
<div class="col-md-4 mb-3">
<a href="<?=Root?>/views/admin/superAdmin/addAdmin.php" class="btn btn-warning w-100 py-3">Promote to Admin</a>
</div>
<?php endif; ?>
<div class="col-md-4 mb-3">
<a href="<?=Root?>/views/home.php" class="btn btn-secondary w-100 py-3">Back to Home</a>
</div>
</div>
</div>

<div class="tables-container">
<div class="row">
<div class="col-md-6 mb-4">
<h3>Admins</h3>
<table class="table">
<thead>
<tr>
<th>Username</th>
<?php if ($_SESSION['account']['superAdmin']): ?>
<th>Actions</th>
<?php endif; ?>
</tr>
</thead>
<tbody>
<?php foreach($admins as $admin): ?>
<tr>
<td>
<?php if ($admin['username'] === $_SESSION['account']['username']): ?>
<strong><a href="<?=Root;?>/views/profile.php"><?= htmlspecialchars($admin['username']); ?></a> (You)</strong>
<?php else: ?>
<a href="<?=Root;?>/views/authorPage.php?profileId=<?=$admin['ID']?>"><?= htmlspecialchars($admin['username']); ?></a>
<?php endif; ?>
</td>
<?php if ($_SESSION['account']['superAdmin'] && $_SESSION['account']['username'] !== $admin['username'] ): ?>
<td>
<a href="<?=Root?>/views/admin/superAdmin/deleteAdmin.php?username=<?= urlencode($admin['username']); ?>" class="btn btn-sm btn-danger">Remove</a>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<div class="col-md-6 mb-4">
<h3>Users</h3>
<table class="table">
<thead>
<tr>
<th>Username</th>
<?php if (isset($_SESSION['account']['superAdmin'])): ?>
<th>Actions</th>
<?php endif; ?>
</tr>
</thead>
<tbody>
<?php foreach($users as $user): ?>
<tr>
<td>
<?php if ($user['username'] === $_SESSION['account']['username']): ?>
<strong><a href="<?=Root;?>/views/profile.php"><?= htmlspecialchars($user['username']); ?></a> (You)</strong>
<?php else: ?>
<a href="<?=Root;?>/views/authorPage.php?profileId=<?=$user['ID']?>"><?= htmlspecialchars($user['username']); ?></a>
<?php endif; ?>
</td>
<?php if ((isset($_SESSION['account']['superAdmin'])) && $_SESSION['account']['username'] !== $user['username'] ): ?>
<td>
<a href="<?=Root?>/views/admin/deleteUser.php?username=<?= urlencode($user['username']); ?>" class="btn btn-sm btn-danger">Delete</a>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>

<?php require_once __DIR__.'/layouts/footer.php'; ?>