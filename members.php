<?php

session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (isset($_GET['logout']))
	User::logout();
if (!User::isLoggedIn())
	header('Location: index.php');
?>
<!DOCTYPE html>


<html>
	<head>
		<title>Welcome user!</title>
		<link rel="stylesheet" href="styles/home_style.css" media="all"/>
	</head>

	
	<body>
	
	<!--container starts--->
	<div class="container">
		
		<div id="head_wrap">
			<div id="header">
				<ul id="menu">
					<li><a href="home.php">Home</a></li>
					<li><a href="members.php">Members</a></li>
				
				</ul>
				<form method="get" action="members.php" id="form1">
					<input type="text" name="user_query" placeholder="Search a members"/>
					<input type="submit" name="search" value="Search"/>
				</form>
			</div>
		</div>
		<div class="content">
			<div id="user_timeline">
				<div id="user_details">
					<?php
						include('user_details.php');
					?>
				</div>
			</div>
			
			<div id="content_timeline">
				<div id="content_members">
				<?php
				if (isset($_GET['friendAdded']))
				{
					
				}		
				if (isset($_GET['friendRemoved']))
				{
					echo "Friend removed.";
					echo "<br>";
				}					
				if (isset($_GET['user_query']))
				{
					$query = $_GET['user_query'];
					
					echo "You searched for \"{$query}\"";
					$where = " WHERE user_name LIKE '{$query}%' ";
				}
				else
					$where = '';
				$query = mysqli_query($con, "SELECT * FROM users {$where} ORDER BY register_date DESC");
				
				while ($row = mysqli_fetch_array($query))
				{
					$user = new User($row);
					if ($user->getEmail() == User::getCurrent()->getEmail())
						continue;
					echo "<div class='user'>";
					echo "<img src='user/user_images/".$user->getImage()."' align='left' class='avatar' />";
					echo $user->getUsername();
					echo "<br>";
					if (User::getCurrent()->isFriendsWith($con, $user->getId()))
					{
						echo "<a href='remove_friend.php?id=".$user->getId()."'>Unfriend</a>";
						echo "<br>";
						echo "<a href='chat.php?id=".$user->getId()."'>Chat</a>";
					}
					else if (User::getCurrent()->isFriendRequestedFromUser($con, $user->getId()))
						echo "Sent you a friend request. Do you accept? <a href='add_friend.php?id=".$user->getId()."'>Yes</a> <a href='add_friend.php?id=".$user->getId()."&reject'>No</a>";
					else if (User::getCurrent()->isFriendRequestedWith($con, $user->getId()))
						echo "Friend request sent.";
					else
						echo "<a href='add_friend.php?id=".$user->getId()."'>Add as Friend</a>";
					echo "</div>";
					echo "<br>";
					
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<!--container ends--->
	
	</body>


</html>