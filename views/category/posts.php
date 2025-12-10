<?php
require_once __DIR__."/../../user/usersPosts.php";
require_once __DIR__."/../../core/CSRF.php";


if (empty($_GET['categoryId']) )
{
	header ('location:'.Root.'/views/categories.php');
	exit;
}
$view = new UserPosts;
$categoryId = $_GET['categoryId'];
$categoryName = $_GET['categoryName'];
$posts = $view->categoryPosts($categoryId);

require_once __DIR__.'/../layouts/main.php';
?>


<div class="category-posts-page">
<div class="category-header text-center mb-5">
<h1><?= htmlspecialchars($categoryName); ?></h1>
<p class="lead">Posts in this category</p>
</div>

<?php if (empty($posts)): ?>
<div class="alert alert-info text-center">
<h4>No Posts Yet</h4>
<p>No posts have been published in this category yet.</p>
<a href="<?=Root?>/views/posts/create.php" class="btn-primary">Be the first to post</a>
</div>
<?php else: ?>
<div class="posts-count mb-4">
<div class="alert alert-info">
<strong><?= count($posts); ?></strong> posts found in this category
</div>
</div>

<div class="card-container">
<?php foreach($posts as $post): ?>
<div class="card">
<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Post Image"/>
<div class="card-content">
<h5>
<a href="<?=Root?>/views/posts/view.php?postId=<?=$post['post_id']?>"><?= htmlspecialchars($post['title']); ?></a>
</h5>
<p class="text-muted">
<strong>Author:</strong> 
<a href="<?=Root?>/views/authorPage.php?profileId=<?=$post['user_id']?>"><?= htmlspecialchars($post['username']); ?></a>
</p>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="mt-4 text-center">
<a href="<?=Root?>/views/categories.php" class="btn-secondary">Back to Categories</a>
</div>
</div>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>