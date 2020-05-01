<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
31/3/2020
-->

<!--Required modules-->
<?php  include('config.php'); ?>
<?php include('includes/navbar.php'); ?>
<?php include('includes/head_section.php'); ?>

	<title>Register | Security Suite </title>
</head>
<body>
	
	<div class="container">
		
				<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	
<!--	Registration form-->
	
		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="register.php" onsubmit="return userCheck()" id = "usercheck" >
				<h2>Registration Form</h2>
            	<p>Username: </p><input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Username"><br>
				<p>Email Address:</p><input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email"><br>
				<p>Password:</p><input type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
				<p>Confirm password:</p><input type="password" name="password2" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
				<br>
				<p>Password must contain at least one number, one uppercase, and one lowercase letter.  It must also be at least 8 or more characters</p>
				<br>
				<p>Choose the tool you need</p>
				<select name="tools">
					<option value="" selected hidden>--Action-- </option>
					<option value="1">Twitter Scraper</option>
				 </select>
				 <br>
				<button class = "btn" onclick="registered()" type='submit' name="register">Register Details</button>
			</form>
			<br><br>
        	<p>Aready a member?</p>
        	<br>
        	<button id="signButton" class = "btn" name="signBtn">Sign in</button>
    	</div>
</div>
	
    
<?php

  // Get the posted information

    $email		 = mysqli_real_escape_string($conn, $_POST['email']);
    $password      = mysqli_real_escape_string($conn, $_POST['password']);
    $password_2      = mysqli_real_escape_string($conn, $_POST['password2']);
    $username      = mysqli_real_escape_string($conn, $_POST['username']);
    $tool     = mysqli_real_escape_string($conn, $_POST['tools']);
    
    
    if (isset($_POST['register'])){
//        Checks to see if the passwords enter match
        if ($password != $password_2) {
            echo "<script type='text/javascript'>alert('Passwords do not match.  Please try again.');
                            window.location='register.php';
                            </script>";
        } else {
			//       Get user info
			if($email != "") {
				$Query = "SELECT * FROM Users WHERE Username = '$username'";
                $Result = mysqli_query($conn,$Query); 
                $num_results = mysqli_num_rows($Result); 
                
                if ($num_results == 1){
					//Checks if username is already created.
                    echo "<script type='text/javascript'>alert('Username already exists.  Please try again.');
                            window.location='register.php';
                            </script>";
				} else {
					$username = addslashes($username);
					$_SESSION["Name"] = $username;
					$_SESSION["Mail"] = $email;
                    $_SESSION["Pass"] = $password;
                    $_SESSION["Tool"] = $tool;
                
                    $user_mail		 = $_SESSION["Mail"];
                    $user_pass      = $_SESSION["Pass"];
                    $name_user      = $_SESSION["Name"];
                    $tools      = $_SESSION["Tool"];
            
                    //Hash the password
                    $hashed_password = password_hash($userpass, PASSWORD_DEFAULT);
            
                    // Inserts data into User table
                    if($user_mail != ""){   
                        $arr = array('God.png', 'Oogene.png', 'profile.png', 'Blobby.png', 'Djason.png', 'Elijah.png', 'Micro.png');
                        $rand_img = mt_rand(1, 7);  //	 array to add random image for avatar.
                
                        $Query = "INSERT INTO Users (Username, Email, Password, Image, Tools) VALUES ('$name_user','$user_mail', '$hashed_password', '$arr[$rand_img]', '$tools')";
                        $Result = mysqli_query($conn,$Query); 	
                
                        if ($Result == true){           
                            header("Location:index.php");
                        } else if($Result == false){
                            die('Error, we are unable to do this at the moment.  Please try again.');
                            header("Location:index.php");
                        }
                    }
                }
            }
        }
    }
?>

	
	<script>
    
    //Alert for when register button is pressed
    	try {
        	function registered() {
            	alert("Registering...");
        	}
    	} catch (regerr) {
        	document.getElementsByClassName("btn").innerHTML = opTerr.message;
    	}
    
    //Alert for when form is submitting
    	try {
        	function userCheck(){
            	alert("We will now be checking to see if that username already exists.  One moment.");
        	}
    	} catch(usererr) {
        	document.getElementsById("usercheck").innerHTML = opTerr.message;
    	}
    
    //Set Sign In button location
    	try {
        	document.getElementById("signButton").onclick = function () {
            	location.href = "index.php";
        	}
    	} catch (signerr) {
			document.getElementsByName("signBtn").innerHTML = opTerr.message;
    	}
    
	</script>        
        
	
<!-- Footer -->
<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->
