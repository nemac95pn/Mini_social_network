<?php
session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (!User::isLoggedIn())
	header('Location: index.php');

$user_id = $_GET['id'];

if (isset($_GET['reject']))
	User::getCurrent()->rejectFriendRequest($con, $user_id);
else
	User::getCurrent()->addFriend($con, $user_id);

header('Location: members.php?friendAdded');
?>
