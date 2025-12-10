<?php
require_once __DIR__.'/../../user/usersPosts.php';
$view = new UserPosts;
if (empty($_GET['postId']))
{
	header("location: ../home.php");
}
$postId = $_GET['postId'];
$post = $view->readPost($postId);
require_once __DIR__.'/../layouts/main.php';
?>

<html>
<div class="post-view">
	<h2><?= htmlspecialchars($post['title']); ?></h2>
	<div class="post-meta">
		<strong>Author:</strong> <a href="<?=Root;?>/views/authorPage.php?profileId=<?=$post['user_id']?>"><?= htmlspecialchars($post['username']); ?> </a> | 
		<strong>Category:</strong> <a href="<?=Root;?>/views/category/posts.php?categoryId=<?=$post['category_id']?>"><?= htmlspecialchars($post['category_name']); ?> </a>
	</div>
	
	<?php if (isset($_SESSION['account']) && ($_SESSION['account']['username'] === $post['username'])): ?>
	<div class="post-actions">
		<a href="<?=Root?>/views/posts/edit.php?postId=<?=$postId;?>" class="btn">Edit Post</a>
		<?php if ($_SESSION['account']['admin'] || ($_SESSION['account']['username'] === $post['username'])): ?>
		<a href="<?=Root?>/views/posts/delete.php?postId=<?=$postId;?>" class="btn btn-danger">Delete Post</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<div class="post-image mb-4">
		<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid rounded" alt="Post Image"/>
	</div>
	
	<div class="post-content">
		<?= nl2br(htmlspecialchars($post['content'])); ?>
	</div>
</div>
</html>
<?php require_once __DIR__.'/../layouts/footer.php'; ?>
