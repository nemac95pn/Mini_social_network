<?php
session_start();

include("functions/functions.php");
include("template/header.php");
include("template/content.php");
include("login.php");
include("includes/connection.php");
include("includes/user_class.php");
echo "test";
if (!User::isLoggedIn())
	echo "NOPE";
User::autoLogin($con);
if (User::isLoggedIn())
	header('Location: home.php');
?>


