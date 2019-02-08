<?php
session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (!User::isLoggedIn())
	header('Location: index.php');

$tmp = $_FILES['avatar']['tmp_name'];
$newName = User::getCurrent()->getId()."_avatar.jpg";
$newImage = "user/user_images/".$newName;
if (move_uploaded_file($tmp, $newImage))
{
	User::getCurrent()->updateImage($con, $newName);
	
	header('Location: members.php?avatarChanged');
	die();
}

header('Location: members.php?avatarChangeFailed');
?>
