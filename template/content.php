<div id="content">
					<div>
						<image src="images/image.jpg" height="550px" style="float: left; margin-left: 40px;"/>
						
					</div>
					<div id="form2">
						<form action="" method="post">
							<h2>Sing Up Here</h2>
							<table>
								<tr>
									<td align="right">Name:</td>
									<td>
										<input type="text" name="u_name" placeholder="Enter your name" required="required"/>
									</td>
								</tr>
								<tr>
									<td align="right">Password:</td>
									<td>
										<input type="password" name="u_pass" placeholder="Enter your password" required="required"/>
									</td>
								</tr>
								<tr>
									<td align="right">Email:</td>
									<td>
										<input type="email" name="u_email" placeholder="Enter your email" required="required"/>
									</td>
								</tr>
								<tr>
									<td align="right">Country:</td>
									<td>
										<select name="u_country" required="required">
											<option>Select a Country</option>
											<option>Serbia</option>
											<option>Poland</option>
											<option>Finland</option>
											<option>Russia</option>
											<option>Sweden</option>
											<option>Croatia</option>
											<option>Italia</option>
											<option>Montenegro</option>
											<option>Greece</option>
											<option>Ucraine</option>
											<option>Germany</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Gender:</td>
									<td>
										<input type="radio" name="u_gender" value="male"/> Male
										<input type="radio" name="u_gender" value="female"/> Female
										<input type="radio" name="u_gender" value="other"/> Other
									</td>
								</tr>
								<tr>
									<td align="right">Birthday:</td>
									<td>
										<input type="date" name="u_birthday"/>
									</td>
								</tr>
								<tr>
									
									<td colspan="6">
										<button name="sing_up">Sing up</button>
									</td>
								</tr>
							</table>
						</form>
						<?php
						include("user_insert.php");
						
						?>
					</div>
				</div>
	</body>
</html>