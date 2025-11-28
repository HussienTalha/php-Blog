<?php
define ("Root","http://localhost:8000");
require_once __DIR__.'/../user/usersPosts.php';
require_once __DIR__.'/../user/profile.php';

if (! isset($_SESSION['account']))
{
	header ('location:'.Root.'/views/home.php');
	exit;
}
$post = new UserPosts;
$profile = new UserProfile;
$userId = $_SESSION['account']['ID'];
$posts = $post->profilePosts($userId);
if ($_SERVER['REQUEST_METHOD'] ==='POST')
{

	$profile->editProfile();
	header("location:".Root."/views/profile.php");
	exit;
}
?>

<html>
<head>
<title> Profile </title>
</head>
<body>
<?= require_once __DIR__.'/layouts/main.php';?>
<h1 style= "text-align : center;"> Profile </h1>
<?php if(isset ($_SESSION['Edit-Profile-State']))
{
echo $_SESSION['Edit-Profile-State'];
}
?>
<form>
<label for='username'>Edit Username </label>
<input type="text" name="edit-username" placeholder="<?=$_SESSION['account']['username']?>">
<?php if (isset($_SESSION['Edit-Profile-Erros']['username']))
{
	echo $_SESSION['Edit-Profile-Errors']['username'];
}
?>
<label for='email'> Edit Email </label>
<input type="email" name="edit-email" placeholder="<?= $_SESSION['account']['email']?>">
<?php if (isset($_SESSION['Edit-Profile-Errors']['email']))
{
	echo $_SESSION['Edit-Profile-Errors']['email'];
}
?>

<label for='password'> Enter the old password </label>
<input type='password' name='old-password'>
<label for='password'> Enter the new password </label>
<input type="password" name="edit-password">
<label for='password'> Confirm the new password </label>
<input type="password" name="confirm-password">
<?php if (isset($_SESSION['Edit-Profile-Errors']['email']))
{
	echo $_SESSION['Edit-Profile-Errors']['email'];
}
?>
</form>
<div class = "container">
<?php foreach($posts as $onePost) { ?>
<div class= "container">
<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&amp;w=870&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
<div>
<h5>
<a href="<?=Root;?>/views/posts/view.php?$_SESSION['postId']=$post[post_id]"><?= $onePost['title'] ;?> </a>
</h5>
<h6>Author:</h6><a href="<?=Root;?>/views/profile.php?profileId=$post['user_id']"><?= $onePost['username']; ?> </a>
</div>
</div>
<?php };?>
</div>
</body>
</html>


