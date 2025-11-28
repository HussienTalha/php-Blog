<?php
require_once __DIR__.'/../../user/usersPosts.php';
$view = new UserPosts;
if (!isset($_SESSION['postId']))
{
	header("location: ../home.php");
}
$postId = $_SESSION['postId'];
$post = $view->readPost($postId);
?>

<html>
<?= require_once __DIR__.'/../layouts/main.php';?>
<div style="text-align:center;">
	<h2> <?= $post['title'];?> </h2>
	<h6> <?= $post['username'];?> </h2>
<div>
<p>
<?= $post['content'] ;?>
</p>
<?php
if (isset ($_SESSION['account']) && $_SESSION['account']['username'] === $post['username']) {?>
<a href="<?=Root?>/views/posts/edit.php">Edit post</a>
<?php if (($_SESSION['account']['username'] === $post['username']) || $_SESSION['admin']){?>
<a href="<?=Root?>/views/posts/delete.php">Delete Post </a>
<?php }}?>
</html>
