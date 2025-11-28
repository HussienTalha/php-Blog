<?php
session_start();
require_once __DIR__.'/../../user/usersPosts.php';
$create = new userPosts();
$categories = $create->getCategories();
if($_SERVER['REQUEST_METHOD'] 	=== 'POST')
{
	if (isset($_SESSION['account']))
	{
	$state = $create->createPost
		(
		 $_POST['title'],
		 'created',
		 $_POST['content'],
		 $_SESSION['account']['id'],
		 $_POST['category']
		);
	$_SESSION['state'] = $state;
	}
	else
	{
		echo "login first";
	}
	header('location: create.php');
	return;
	
}
?>

<html>
<?= require_once __DIR__.'/../layouts/main.php'; ?>
<?php if (isset($SESSION['state'])){?>
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
<input type='text' name='title' />
<br>
</div>
<div>
<label for='content' rows'50'> Write your Post </label>

<textarea name ='content'></textarea>
<input type="submit" value="publish">
</div>
</form>
</html>
