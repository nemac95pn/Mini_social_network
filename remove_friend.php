<?php
session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (!User::isLoggedIn())
	header('Location: index.php');

$user_id = $_GET['id'];

User::getCurrent()->removeFriend($con, $user_id);

header('Location: members.php?friendRemoved');
?>
