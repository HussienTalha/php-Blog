<?php
require_once __DIR__.'/../../admin/category.php';
require_once __DIR__."/../../core/CSRF.php";

if (empty( $_SESSION['account']) || ! isset($_SESSION['account']['admin']))
{
	header('location: ../categories.php');

	return;
}
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['createCategoryToken'],'createCategoryToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$create = new Category;
	$state = $create->addCategory($_POST['categoryName']);
	$_SESSION['create-category-state'] = $state;
	header('location: create.php');
	return;
}

require_once __DIR__.'/../layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Create Category</h1>
<p class="form-subtitle">Add a new content category</p>
</div>

<div>
<?php if (isset($_SESSION['create-category-state'])):?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['create-category-state']); ?></div>
<?php unset($_SESSION['create-category-state']);
endif;?>
</div>

<form method="post">

 <?php echo $CSRF::getTokenField('createCategoryToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="form-group">
<label for ="add-category" class="required">Category Name</label>
<input type="text" name='categoryName' class="form-control" placeholder="Enter category name">
<small class="form-text">Use descriptive names (e.g., Technology, Travel, Food)</small>
</div>

<div class="form-actions">
<button type="submit" class="btn-success">Add Category</button>
<a href="<?=Root?>/views/categories.php" class="btn-secondary">View All Categories</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>
