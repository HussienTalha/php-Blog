<?php
require_once __DIR__.'/../../user/usersPosts.php';
require_once __DIR__."/../../core/CSRF.php";

if (empty( $_SESSION['account']))
{
	header('location: ../home.php');
	return;
}
$create = new UserPosts;
$categories = $create->getCategories();
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['createPostToken'],'createPostToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$category = $_POST['category']?? "uncategorized";
	if (isset($_SESSION['account']))
	{
	$state = $create->createPost
		(
		 $_POST['title'],
		 'created',
		 $_POST['content'],
		 $_SESSION['account']['ID'],
		 'drama'
		);
	$_SESSION['state'] = $state;
	}
	else
	{
		$_SESSION['state'] = "login first";
	}
	header('location: create.php');
	return;
	
}
 require_once __DIR__.'/../layouts/main.php';
?>

<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Create New Post</h1>
<p class="form-subtitle">Share your thoughts with the community</p>
</div>

<?php if (isset($_SESSION['state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['state']); ?></div>
<?php unset($_SESSION['state']); ?>
<?php endif; ?>

<form method='post'>

	 <?php echo $CSRF::getTokenField('createPostToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for='categories'>Choose Category</label>
<select name="category" class="form-control">
<?php foreach ($categories as $category): ?>
<option value = "<?= htmlspecialchars($category['category_name']); ?>"><?= htmlspecialchars($category['category_name']); ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label for='title' class="required">Title</label>
<input type='text' name='title' class="form-control" placeholder="Enter a compelling title" />
<small class="form-text">Make it descriptive and attention-grabbing</small>
</div>

<div class="form-group">
<label for='content' class="required">Content</label>
<textarea name='content' class="form-control" placeholder="Write your post here..." rows="12"></textarea>
<small class="form-text">Minimum 50 characters. You can use basic HTML formatting.</small>
</div>

<div class="form-actions">
<input type="submit" value="Publish Post" class="btn-success">
<a href="<?=Root?>/views/home.php" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>