<?php

include("includes/connection.php");
if(isset($_POST['sing_up']))
	{
		
		$name = $_POST['u_name'];
		$pass = $_POST['u_pass'];
		$email = $_POST['u_email'];
		$country = $_POST['u_country'];
		$gender = $_POST['u_gender'];
		$b_day = $_POST['u_birthday'];
		$date = date("d-m-y");
		$status = "unverified";
		$hash = md5( rand(0,1000) );
		
		$get_email = "select * from users where user_email='$email'";
		$run_email = mysqli_query($con,$get_email);
		$check = mysqli_num_rows($run_email);
		
		if($check==1)
		{
			echo "<script>alert('Email is already registered, pls try another!')</script>";
			exit();
		}
		if(strlen($pass)<8)
		{
			echo "<script>alert('Password is short, minimum 8 characters!')</script>";
			exit();
		}
		else
		{
			
			$insert = "insert into users (user_name,user_pass,user_email,user_country,user_gender,user_b_day,user_image,register_date,last_login,status,hash) values ('$name','$pass','$email','$country','$gender','$b_day','default.jpg',NOW(),'$date','$status','$hash')";
			
			echo $insert;
			
			$run_insert = mysqli_query($con,$insert);
				
				
			
				if($run_insert)
				{
					
					$to      = $email; // Send email to our user
					$subject = 'Signup | Verification'; // Give the email a subject 
					$message = '
 
					Thanks for signing up!
					Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
					 
					------------------------
					Username: '.$name.'
					Password: '.$pass.'
					------------------------
					 
					Please click this link to activate your account:
					http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'
					 
					'; // Our message above including the link
										 
					$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email
					
					
					
					$_SESSION['user_email']=$email;
					echo "<script>alert('Registration Successful!')</script>";
					echo "<script>window.open('home.php','_self')</script>";
				}
		}
	}
?>