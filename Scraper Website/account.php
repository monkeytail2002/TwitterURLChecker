<!--Required modules-->
<?php require_once('config.php'); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php'); ?>


<?php //Checks session vailidity
if($_SESSION["Valid"]){
	} else {
	header("Location:index.php");
}
?>


	<title>Account | Security Suite</title>
</head>
<body>
	<div class="container">	
		<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>

<!--	This section displays the current user details.	-->
		<section class = "main">
			<aside>
				<div class = "Display Users">
					
					<table border = "1">
						<tr>
							<th >Username</th>
							<th >Email</th>
						</tr>
						
						
		<?php 
						$session_id = $_SESSION["UserId"]; 
						$Query = "SELECT * FROM Users WHERE UserId  = '$session_id'";
						$result = mysqli_query($conn,$Query);
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
							echo "<td>".$row['Username']."</td>";
							echo "<td>".$row['Email']."</td>";
							echo "</tr>";
						}
						

			?>

					</table>
		
		
	
	
			</div>
		</aside>
	</section>
	
<!--	this section deals with changing the username, email or password-->
	
	<section class = "changedet">
		<div class = "changedets">
			<form action="update.php" method="post">
				<h2>Change Username or Email?</h2>
				<br>
				
				<p>Enter a new username: </p>
				<input type="text" name="newun" placeholder="New username"><br>
				<p>Enter a new email: </p>
				<input type="email" name="newmail" placeholder="New email address"><br>
				<button class="btn" type="submit" name="login_btn">Submit</button>
		
			</form>
		<br><br>
		
		</div>
		
<!--		Section for changing password-->
		<div class = "changeword">
			<form action="update.php" method="post" >
				<h2>Change Password?</h2>
				<br>
				<p>Old Password: </p>
				<input type="password" name="oldpw" placeholder="Old Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
				<p>New Password: </p>
				<input type="password" name="Newword"  placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
				<br>
				<p>Password must contain at least one number, one uppercase, and one lowercase letter.  It must also be at least 8 or more characters</p>
				<br>
				<p>Confirm New Password: </p>
				<input type="password" name="Confpass"  placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
				<br>	
				<button class="btn" type="submit" name="login_btn">Submit</button>
			</form>
		</div>

	</section>
		
	</div>

	<script>
		
		//	Script for opening the nav menu via click
		try{
			function openNav(){
				document.getElementById("mySidenav").style.width = "250px";
			}
		} catch(openerr){
			document.getElementById("mySidenav").innerHTML = openerr.message;
		}

		//Script for closing the nav menu	
		try{
			function closeNav() {
				document.getElementById("mySidenav").style.width = "0";
			}
		} catch(closeerr){
			document.getElementById("mySidenav").innerHTML = closeerr.message;
		}

		//script for making sure that the onclick doesn't default when ontouch triggers	for opening the nav menu
		try {
			function openTouch(e){
				e.preventDefault();
				e.target.onclick();
			}
		} catch(opTerr){
				document.getElementById("mySidenav").innerHTML = opTerr.message;
		}

		//script for making sure that the onclick doesn't default when ontouch triggers	for closing the nav menu
		try {
			function closeTouch(e){
				e.preventDefault();
				e.target.onclick();
			}
		} catch(clTerr){
				document.getElementById("mySidenav").innerHTML = clTerr.message;
		}	
	
		</script>		
	

	<?php require_once( ROOT_PATH . '/includes/footer.php') ?>