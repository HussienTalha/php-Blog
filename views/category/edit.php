<?php
require_once __DIR__.'/../../admin/category.php';
require_once __DIR__."/../../core/CSRF.php";

if  (empty( $_SESSION['account']) || ! isset($_SESSION['account']['admin']))
{
	header('location: ../categories.php');

	return;
}

$oldCategory = $_GET['categoryName']??null;
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['editCategoryToken'],'editCategoryToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }

	$edit = new Category;
	$state = $edit->editCategory($oldCategory,$_POST['newCategory']);

	$_SESSION['edit-category-state'] = $state;
	header('location: edit.php');
	return;
}
require_once __DIR__.'/../layouts/main.php';
?>
<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Edit Category</h1>
<p class="form-subtitle">Update category information</p>
</div>

<?php if(isset($_SESSION['edit-category-state'] )): ?> 
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['edit-category-state']); ?></div>
<?php unset($_SESSION['edit-category-state']);
endif;
?>

<form method="post">

	 <?php echo $CSRF::getTokenField('editCategoryToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="alert alert-info">
<p><strong>Current Category Name:</strong> <span class="badge bg-primary"><?= htmlspecialchars($oldCategory); ?></span></p>
</div>

<div class="form-group">
<label for="edit-category" class="required">New Category Name</label>
<input type="text" name='newCategory' class="form-control" placeholder="<?= htmlspecialchars($oldCategory); ?>" value="<?= htmlspecialchars($oldCategory); ?>">
<small class="form-text">Enter the new name for this category</small>
</div>

<div class="form-actions">
<button type="submit" class="btn-primary">Update Category</button>
<a href="<?=Root?>/views/categories.php" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>
