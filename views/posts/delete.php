<?php
require_once __DIR__."/../../user/usersPosts.php";
require_once __DIR__."/../../core/CSRF.php";

if (empty( $_SESSION['account']))
{
	header('location: ../home.php');
	return;
}
$delete = new UserPosts;
if (! isset($_GET['postId']))
{
	header("location: create.php");
	exit;
}
$postId = $_GET['postId'];
$post = $delete->readPost($postId);
$authorUsername = $post['username'];
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['deletePostToken'],'deletePostToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	if (isset($_SESSION['account']))
	{
		$state = $delete->deletePost($postId,$authorUsername);
	$_SESSION['state'] = $state;

	}
	else
	{
		echo 'login first';
	}
	header("location: ../home.php");
	return ;
}
require_once __DIR__.'/../layouts/main.php';
?>


<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Delete Post</h1>
<p class="form-subtitle">Permanently remove this post</p>
</div>

<div class="post-preview mb-4">
<div class="alert alert-danger">
<strong>Warning:</strong> This action cannot be undone.
</div>

<div class="card">
<div class="card-body">
<h3><?= htmlspecialchars($post['title']); ?></h3>
<p class="text-muted">
<strong>Author:</strong> <?= htmlspecialchars($post['username']); ?> | 
<strong>Status:</strong> <span class="badge bg-warning">To be deleted</span>
</p>
<div class="post-content-preview">
<?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?>...
</div>
</div>
</div>
</div>

<form method="post">

 <?php echo $CSRF::getTokenField('deletePostToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for="confirmMessage">Type "DELETE" to confirm</label>
<input type="text" name="confirmMessage" class="form-control" placeholder="Type DELETE here" pattern="DELETE" required>
<small class="form-text">This confirms you want to delete this post</small>
</div>

<div class="form-actions">
<button type="submit" class="btn-danger">Delete Permanently</button>
<a href="<?=Root?>/views/posts/view.php?postId=<?= $postId; ?>" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>