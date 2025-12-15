<?php

if (session_status() !== PHP_SESSION_ACTIVE)
{
session_start();
}
require_once __DIR__."/../core/config.php";
if (isset($_SESSION['account']))
	{
		session_destroy();
	}
header("location: /views/home.php");
