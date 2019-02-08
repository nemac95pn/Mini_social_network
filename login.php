<?php
session_start();
include("includes/connection.php");
if(isset($_POST['login']))
	{
		
		$email = $_POST['email'];
		$pass = $_POST['pass'];
	
	
		$get_user = "select * from users where user_email='$email' AND user_pass='$pass'";
		$run_user = mysqli_query($con,$get_user);
		$check = mysqli_num_rows($run_user);

		if($check==1)
		{
			
			$_SESSION['user_email']=$email;
			echo "<script>window.open('home.php','_self')</script>";
			
		}
		else
		{
			echo "<script>alert('Password or email is not correct!')</script>";
		}
			
	}
?>