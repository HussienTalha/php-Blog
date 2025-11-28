<?php
session_start();
require_once __DIR__."/../../user/usersPosts.php";
$delete = new UserPosts;
if (! isset($_SESSION['postId']))
{
	header("location: create.php");
	exit;
}
$postId = $_SESSION['postId'];
$post = $delete->readPost($postId);
$authorUsername = $post['username']
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (isset($_SESSION['account']))
	{
		$state = $delete->deletePost($postId,$authorUsername);
	$_SESSION['state'] = $state;

	}
	else
	{
		echo 'login first';
	}
	header("location: /../home.php");
	return ;
}
?>

<html>
<?= require_once __DIR__.'/../layouts/main.php'; ?>
<div style="text-align:center;">
	<h2> <?= $post['title'];?> </h2>
	<h6> <?= $post['username'];?> </h2>
<div>
<p>
<?= $post['content'] ;?>
</p>
<form method="post">
<input type="submit" value="Delete">
</form>
</div>
</form>
</html>
