<?php

session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (isset($_GET['logout']))
	User::logout();
if (!User::isLoggedIn())
	header('Location: index.php');

    $user_id = $_POST['user_id'];

	User::getCurrent()->messageUser($con, $user_id, $_POST['message']);

header('Location: chat.php?id='.$user_id);
?>