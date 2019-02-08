<?php
$username = User::getCurrent()->getUsername();
						$country = User::getCurrent()->getCountry();
						$email = User::getCurrent()->getEmail();
						
						$image = User::getCurrent()->getImage();
						echo "<img src=\"user/user_images/{$image}\" class=\"avatar\"  />";
						echo "<br>";
						echo "Username: " . $username;
						echo "<br>";
						echo "Country: " . $country;
						echo "<br>";
						echo "Email: " . $email;
						echo "<br>";
						echo "<form method='POST' action='change_avatar.php' enctype='multipart/form-data'>";
							echo "<input type='file' name='avatar'>";
							echo "<input type='submit' value='Change'>";
						echo "</form>";
						echo "<br>";
						echo "<a href='?logout'>Logout</a>";
?>