<?php ?>
<html>
<head>
<title> Categories </title>
</head>
<body>
<h1 style="text-align:center;">Categories</h1>
<div class="container">
<?php 
foreach ($posts as $post) {?>
<div class ="card">
<img src = "<?php $post["img"] ?>" alt = "img" style ="width: 100%;">
<div class "container">
<h1><a href ="/posts?id=<?php $post["id"]?>"><?php $post['title']?></a></h1>
<h5>Author: </h5><a href= "/user?id=<?php $post["user_id"]?>"><?php $post['username']?></a>
</div>
<h5> Category: </h5><a href="/category?id=<?php $post["category_id"]?>"<?php $category['category_name']?>
<?php }; ?>
</div>
</div>
</body>
</html>
