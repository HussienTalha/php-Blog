<?php
session_start();
require_once __DIR__.'/../../user/usersPosts.php';
$edit = new UserPosts();
if (isset ($_SESSION['postId']))
{
	$postId= $_SESSION['postId'];
}
else
{
	header('location: create.php');
}
$post = $edit->readPost($postId);
if ($_SERVER['REQUEST_METHOD'] ==='POST')
{
	if (isset($_SESSION['account']))
	{
	$state = $edit->editPost
		(
			$post['username'],
			$postId,
			$_POST['title'],
			$_POST['content'],
			$_POST['category']
			'EDITED'
		);
		$_SESSION['state'] = $state;
	}
	else 
	{
		$_SESSION['state'] = 'login first';
	}
	header("location: edit.php");
	return;

}
?>
<html>
<?= require_once __DIR__.'/../layouts/main.php'; ?>
<?php if (isset($_SESSION['state'])){?>
<?= $_SESSION['state'];} ?>
<form method='post'>
<label for'categories'> Choose category </label>
<select name="category">
<?php foreach ($categoris as $category){?>
<option> <?= $category['category_name'];?> </option>
<?php }?>
</select>

</select>
<div>
<label for='title'> Title </label>
<input type='text' name='title' value="<?= $post['title'];?>" />
</div>
<div>
<label for='content' rows'50'> Write your Post </label>

<textarea name ='content'>
<?= $post['content'] ; ?>
</textarea>
<input type="submit" value="Edit">
</div>
</form>
</html>
