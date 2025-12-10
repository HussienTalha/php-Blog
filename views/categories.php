<?php
require_once __DIR__.'/../user/usersPosts.php';
$category = new UserPosts;
$categoryIndex  = $category->getCategories();
require_once __DIR__.'/layouts/main.php';
?>
<div class="categories-page">
<div class="categories-header text-center mb-5">
<h1>Content Categories</h1>
<p class="lead">Browse posts by category</p>
</div>

<?php if (isset($_SESSION['account']['admin'])): ?>
<div class="admin-actions mb-4">
<a href="<?=Root?>/views/category/create.php" class="btn-success">+ Add New Category</a>
</div>
<?php endif; ?>

<div class="categories-list">
<?php if (empty($categoryIndex)): ?>
<div class="alert alert-info text-center">
<h4>No Categories Yet</h4>
<p>No categories have been created yet.</p>
<?php if (isset($_SESSION['account']['admin'])): ?>
<p><a href="<?=Root?>/views/category/create.php" class="btn btn-sm btn-success">Create First Category</a></p>
<?php endif; ?>
</div>
<?php else: ?>
<div class="row">
<?php foreach ($categoryIndex as $oneCategory): ?>
<div class="col-md-4 mb-4">
<div class="card h-100">
<div class="card-body text-center">
<h4 class="card-title">
<a href="<?= Root ?>/views/category/posts.php?categoryId=<?=$oneCategory['category_id'];?>&categoryName=<?= urlencode($oneCategory['category_name']); ?>" class="text-decoration-none">
<?= htmlspecialchars($oneCategory['category_name']); ?>
</a>
</h4>
<?php if(isset($_SESSION['account']['admin'])): ?>
<div class="category-actions mt-3">
<a href="<?= Root?>/views/category/edit.php?categoryName=<?= urlencode($oneCategory['category_name']); ?>" class="btn-sm btn-warning">Edit</a>
<a href="<?= Root?>/views/category/delete.php?categoryName=<?= urlencode($oneCategory['category_name']); ?>" class="btn-sm btn-danger">Delete</a>
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>
<?php require_once __DIR__.'/layouts/footer.php'; ?>