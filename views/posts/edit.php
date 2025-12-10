<?php
require_once __DIR__.'/../../user/usersPosts.php';
require_once __DIR__."/../../core/CSRF.php";

if (empty( $_SESSION['account']))
	{
	header('location: ../home.php');
	return;
}
$edit = new UserPosts();
if (isset ($_GET['postId']))
{
	$postId= $_GET['postId'];
}
else
{
	header('location: create.php');
}
$post = $edit->readPost($postId);
$categories = $edit->getCategories();
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['editPostToken'],'editPostToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	if (isset($_SESSION['account']))
	{
	$state = $edit->editPost
		(
			$post['username'],
			$postId,
			$_POST['title'],
			$_POST['content'],
			$_POST['category'],
			'EDITED'
		);
		$_SESSION['state'] = $state;
	}
	else 
	{
		$_SESSION['state'] = 'login first';
	}
	header("location: edit.php");
	return;

}
require_once __DIR__.'/../layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Edit Post</h1>
<p class="form-subtitle">Update your post content</p>
</div>

<?php if (isset($_SESSION['state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['state']); ?></div>
<?php unset($_SESSION['state']); ?>
<?php endif; ?>

<form method='post'>

	 <?php echo $CSRF::getTokenField('editPostToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for='categories'>Category</label>
<select name="category" class="form-control">
<?php foreach ($categories as $category): ?>
<option value="<?= htmlspecialchars($category['category_name']); ?>" <?= ($category['category_name'] == $post['category_name']) ? 'selected' : ''; ?>>
<?= htmlspecialchars($category['category_name']); ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label for='title' class="required">Title</label>
<input type='text' name='title' class="form-control" placeholder="<?= htmlspecialchars($post['title']); ?>" value="<?= htmlspecialchars($post['title']); ?>" />
</div>

<div class="form-group">
<label for='content' class="required">Content</label>
<textarea name='content' class="form-control" rows="15"><?= htmlspecialchars($post['content']); ?></textarea>
<small class="form-text">Edit your post content here</small>
</div>

<div class="form-actions">
<input type="submit" value="Update Post" class="btn-primary">
<a href="<?=Root?>/views/posts/view.php?postId=<?= $postId; ?>" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>
