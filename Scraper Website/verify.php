<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
07/4/2020
-->

<?php require_once('config.php');?>


<!DOCTYPE html>
<html lang - "en">
	<head>


		<title>verify user</title>



	</head>
	
	<body>
<?php


	 //Now get the information from the sign in form

	 $username	    = mysqli_real_escape_string($conn, $_POST['username']);
	 $user_password  = mysqli_real_escape_string($conn, $_POST['password']);

	 $Query = "SELECT * FROM Users WHERE Username = '$username'";

	 $Result = mysqli_query($conn,$Query);

	 $num_results = mysqli_num_rows($Result);	

	 if ($num_results==1) {
		 $Result = mysqli_query($conn,$Query);
		 $Row = mysqli_fetch_assoc($Result);
		 $user_id = $Row['UserId'];
		 $email = $Row['Email'];
		 $username = $Row['Username'];
		 $hashed_password = $Row['Password'];
		 $user_level = $Row['Role'];

		 //Verify the password entered.
                  
         if (password_verify($UserPassword,$HashedPassword)){
			 
			 $_SESSION['UserId'] = $user_id;
			 $_SESSION['Email'] = $email;
			 $_SESSION['UserName'] = $username;
	 	 	 $_SESSION['Valid'] = 'True';
         	 $_SESSION['UserLevel'] = $user_level;
			 $_SESSION['HP'] = $hashed_password;
			 $_SESSION['susp'] = $Row['Suspended'];
			 setcookie('Current_user',$username);
			 
			 echo "<script type='text/javascript'>alert('Logging you in now');
				window.location='main.php';
				</script>";          
		 } else {
			 echo "<script type='text/javascript'>alert('Incorrect username or password.  Please try again');
			 window.location='index.php';
			 </script>";
	         }
	 } else {
		 echo "<script type='text/javascript'>alert('User not found');
				window.location='index.php';
				</script>";
	 }
        
        ?>

    
    
    </body>
    </html>
