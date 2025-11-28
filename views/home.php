<?php
require_once __DIR__.'/../user/usersPosts.php';
$home = new UserPosts;
$index = $home->index();
?>
<html>
<head>
<title> home </title>
</head>
<body>
<?= require_once __DIR__.'/layouts/main.php';?>
<h1 style= "text-align : center;"> Home </h1>
<div class = "container">
<?php foreach($index as $post) { ?>
<div class= "container">
<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
<div>
<h5>
<a href="<?=Root;?>/views/posts/view.php?$_SESSION['postId']=$post[post_id]"><?= $post['title'] ;?> </a>
</h5>
<h6>Author:</h6><a href="<?=Root;?>/views/profile.php?profileId=$post['user_id']"><?= $post['username']; ?> </a>
</div>
</div>
<?php };?>
</div>
</body>
</html>
