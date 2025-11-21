<?php

session_start();
if (isset($_SESSION['account']))
	{
		session_destroy();
	}
header("location: /../views/home.php");
