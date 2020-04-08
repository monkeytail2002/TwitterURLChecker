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

	 $Username	    = mysqli_real_escape_string($conn, $_POST['username']);
	 $UserPassword  = mysqli_real_escape_string($conn, $_POST['password']);

	 $Query = "SELECT * FROM Users WHERE Username = '$Username'";

	 $Result = mysqli_query($conn,$Query);

	 $NumResults = mysqli_num_rows($Result);	

	 if ($NumResults==1)
	 {


	 	$Result = mysqli_query($conn,$Query);
	 	$Row = mysqli_fetch_assoc($Result);
        $UserId = $Row['UserId'];
	 	$Email = $Row['Email'];
	 	$UserName = $Row['Username'];
        $HashedPassword = $Row['Password'];
        $UserLevel = $Row['Role'];

		 //Verify the password entered.
                  
         if (password_verify($UserPassword,$HashedPassword)){
			 
			 $_SESSION['UserId'] = $UserId;
			 $_SESSION['Email'] = $Email;
			 $_SESSION['UserName'] = $UserName;
	 	 	 $_SESSION['Valid'] = 'True';
         	 $_SESSION['UserLevel'] = $UserLevel;
			 $_SESSION['HP'] = $HashedPassword;
			 $_SESSION['susp'] = $Row['Suspended'];
			 setcookie('Current_user',$UserName);
			 
				echo "<script type='text/javascript'>alert('Logging you in now');
				window.location='main.php';
				</script>";
                 
         }
		 
		 
         else{
			 echo "<script type='text/javascript'>alert('Incorrect username or password.  Please try again');
				window.location='index.php';
				</script>";
	         }
     }



	 	else
	 	{

			echo "<script type='text/javascript'>alert('User not found');
				window.location='index.php';
				</script>";


	 	}
        
        ?>

    
    
    </body>
    </html>
