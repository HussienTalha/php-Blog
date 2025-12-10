<?php
require_once __DIR__.'/../user/usersPosts.php';
$home = new UserPosts;
$index = $home->index();
require_once __DIR__.'/layouts/main.php';
?>
<html>
<head>
<title>Home</title>
</head>
<body>

<h1>Home</h1>
<?php if (isset($_SESSION['account'])):?>
<div class="mb-3">
<a href="<?=Root?>/views/posts/create.php" class="btn btn-primary">Create Post</a>
</div>
<?php endif;?>

<div class="card-container">
<?php foreach($index as $post) { ?>
<div class="card">
<a href="<?=Root;?>/views/posts/view.php?postId=<?=$post['post_id']?>">
 <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/></a>
<div class="card-content">
<h5>
<a href="<?=Root;?>/views/posts/view.php?postId=<?=$post['post_id']?>"><?= htmlspecialchars($post['title']);?> </a>
</h5>
<p class="text-muted">Author: <a href="<?=Root;?>/views/authorPage.php?profileId=<?=$post['user_id']?>"><?= htmlspecialchars($post['username']); ?> </a></p>
<p class="text-muted">Category: <a href="<?=Root;?>/views/category/posts.php?categoryId=<?=$post['category_id']?>"><?= htmlspecialchars($post['category_name']); ?> </a></p>
</div>
</div>
<?php };?>
</div>

</body>
</html>
<?php require_once __DIR__.'/layouts/footer.php'; ?>
