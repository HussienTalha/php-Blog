<?php
require_once __DIR__.'/../../admin/category.php';
require_once __DIR__."/../../core/CSRF.php";

 if (empty( $_SESSION['account']) || ! isset($_SESSION['account']['admin']))
{
	header('location: ../categories.php');

	return;
}
$categoryName = $_GET['categoryName']?? null;
$CSRF = new CSRF;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $state = $CSRF->validateToken($_POST['deleteCategoryToken'],'deleteCategoryToken');
	if (! $state)
  {
    $_SESSION['csrf-state'] = "invalid token";
    die;
  }
	$delete = new Category;
	$state = $delete->deleteCategory($_POST['categoryName']);
	$_SESSION['delete-category-state'] = $state;
	header('location: ../categories.php');
	return;
}
require_once __DIR__.'/../layouts/main.php';
?>

<div class="form-page">
<div class="form-wrapper">
<div class="form-header">
<h1>Delete Category</h1>
<p class="form-subtitle">Remove category from the system</p>
</div>

<?php if (isset($_SESSION['delete-category-state'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_SESSION['delete-category-state']); ?></div>
<?php unset($_SESSION['delete-category-state']);?>
<?php endif; ?>

<form method="post">
 <?php echo $CSRF::getTokenField('deleteCategoryToken');?>
  <?php if (isset($_SESSION['csrf-state'])):?>
  <?= $_SESSION['csrf-state'] ;?>
  <?php unset($_SESSION['csrf-state']);
  endif;?>

<div class="alert alert-danger">
<strong>Warning:</strong> Deleting this category will affect all posts associated with it.
</div>

<div class="form-group">
<label for="categoryName" class="required">Category Name</label>
<input type="text" name="categoryName" class="form-control" placeholder="<?= htmlspecialchars($categoryName); ?>" value="<?= htmlspecialchars($categoryName); ?>">
<small class="form-text">Confirm the category name to delete</small>
</div>

<div class="form-group">
<div class="form-check">
<input class="form-check-input" type="checkbox" id="confirmDelete" required>
<label class="form-check-label" for="confirmDelete">
I understand that all posts in this category will be affected
</label>
</div>
</div>

<div class="form-actions">
<button type="submit" class="btn-danger">Delete Category</button>
<a href="<?=Root?>/views/categories.php" class="btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>
