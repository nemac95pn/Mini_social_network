<?php

session_start();
include("includes/connection.php");
include("includes/user_class.php");
User::autoLogin($con);

if (isset($_GET['logout']))
	User::logout();
if (!User::isLoggedIn())
	header('Location: index.php');

$user = User::constructFromUserId($con, $_GET['id']);

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
					echo "You're chatting with " . $user->getUsername();
					echo "<form method='POST' action='chat_post.php'>";
					echo "<textarea name='message'></textarea>";
					echo "<input type='hidden' name='user_id' value='".$user->getId()."'>";
					echo "<input type='submit' value='Send'>";
					
					$chatData = User::getCurrent()->getChatWithUser($con, $user->getId());
					echo "<br><br>";
					foreach ($chatData as $data)
					{
						$t_user = User::constructFromUserId($con, $data['user_id1']);
						echo $t_user->getUsername() . " said: <br>";
						echo $data['message'];
						echo "<hr><br>";
					}
				?>
				</div>
			</div>
		</div>
	</div>
	<!--container ends--->
	
	</body>


</html>