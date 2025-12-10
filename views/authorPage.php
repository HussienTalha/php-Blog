<?php
require_once __DIR__.'/../user/usersPosts.php';
if (empty($_GET['profileId']))
{
	header ('location:'.Root.'/views/home.php');
	exit;
}
$userId = $_GET['profileId'];
$author = new UserPosts;
$posts = $author->profilePosts($userId); 


require_once __DIR__.'/layouts/main.php';
?>

<div class="author-page">
<div class="author-header text-center mb-5">
<h1>Author Profile</h1>
<p class="lead">Browse all posts by this author</p>
</div>

<?php if (empty($posts)): ?>
<div class="alert alert-info text-center">
<h4>No Posts Yet</h4>
<p>This author hasn't published any posts yet.</p>
</div>
<?php else: ?>
<div class="author-stats mb-4">
<div class="card">
<div class="card-body">
<h5>Author Statistics</h5>
<p><strong>Total Posts:</strong> <?= count($posts); ?></p>
</div>
</div>
</div>

<h3 class="mb-4">Published Posts</h3>
<div class="card-container">
<?php foreach($posts as $onePost): ?>
<div class="card">
<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
<div class="card-content">
<h5>
<a href="<?=Root;?>/views/posts/view.php?postId=<?=$onePost['post_id']?>"><?= htmlspecialchars($onePost['title']); ?> </a>
</h5>
<p class="text-muted">
<strong>Category:</strong> 
<a href="<?= Root;?>/views/category/posts.php?categoryId=<?=$onePost['category_id'];?>&categoryName=<?= urlencode($onePost['category_name']); ?>">
<?= htmlspecialchars($onePost['category_name']); ?>
</a>
</p>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="mt-4 text-center">
<a href="<?=Root;?>/views/home.php" class="btn-secondary">Back to Home</a>
</div>
</div>
<?php require_once __DIR__.'/layouts/footer.php'; ?>
