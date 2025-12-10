<?php
require_once __DIR__.'/../user/usersPosts.php';
require_once __DIR__.'/../user/profile.php';
require_once __DIR__."/../core/CSRF.php";
if (empty($_SESSION['account']))
{
	header ('location:'.Root.'/views/home.php');
	exit;
}
$post = new UserPosts;
$profile = new UserProfile;
$userId = $_SESSION['account']['ID'];
$posts = $post->profilePosts($userId);
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['profileToken'],'profileToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$profile->editProfile();
	header("location:".Root."/views/profile.php");
	exit;
}
require_once __DIR__.'/layouts/main.php';
?>

<html>
<head>
<title>Profile</title>
</head>
<body>
<div class="profile-header">
<h1>Profile</h1>
<?php if(isset ($_SESSION['Edit-Profile-State'])): ?>
<div class="alert alert-info">
<?= htmlspecialchars($_SESSION['Edit-Profile-State']); ?>
</div>
<?php unset($_SESSION['Edit-Profile-State']); ?>
<?php endif;?>

<?php if (isset($_SESSION['account'])):?>
<div class="mb-3">
<a href="<?=Root?>/views/posts/create.php" class="btn 	btn-primary">Create Post</a>
</div>
<?php endif;?>
</div>

<div class="profile-form">
<h4>Edit Profile</h4>
<form method="post">
 <?php echo $CSRF::getTokenField('profileToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for='username'>Edit Username</label>
<input type="text" name="edit-username" class="form-control" placeholder="<?= htmlspecialchars($_SESSION['account']['username']); ?>">
<?php if (isset($_SESSION['Edit-Profile-Errors']['username'])): ?>
<div class="alert alert-danger">
<?= htmlspecialchars($_SESSION['Edit-Profile-Errors']['username']); ?>
</div>
<?php unset($_SESSION['Edit-Profile-Errors']['username']); ?>
<?php endif; ?>
</div>

<div class="form-group">
<label for='email'>Edit Email</label>
<input type="email" name="edit-email" class="form-control" placeholder="<?= htmlspecialchars($_SESSION['account']['email']); ?>">
<?php if (isset($_SESSION['Edit-Profile-Errors']['email'])): ?>
<div class="alert alert-danger">
<?= htmlspecialchars($_SESSION['Edit-Profile-Errors']['email']); ?>
</div>
<?php unset($_SESSION['Edit-Profile-Errors']['email']); ?>
<?php endif; ?>
</div>

<div class="form-group">
<label for='old-password'>Enter the old password</label>
<input type='password' name='old-password' class="form-control">
</div>

<div class="form-group">
<label for='edit-password'>Enter the new password</label>
<input type="password" name="edit-password" class="form-control">
</div>

<div class="form-group">
<label for='confirm-password'>Confirm the new password</label>
<input type="password" name="confirm-password" class="form-control">
</div>

<button type="submit" class="btn">Update</button>
</form>
</div>

<h3>My Posts</h3>
<div class="card-container">
<?php foreach($posts as $onePost) { ?>
<div class="card">
<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
<div class="card-content">
<h5>
<a href="<?=Root;?>/views/posts/view.php?postId=<?=$onePost['post_id']?>"><?= htmlspecialchars($onePost['title']); ?> </a>
</h5>
<p class="text-muted">Category: <?= htmlspecialchars($onePost['category_name']); ?></p>
</div>
</div>
<?php };?>
</div>
</body>
</html>
<?php require_once __DIR__.'/layouts/footer.php'; ?>
