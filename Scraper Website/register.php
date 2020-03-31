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
    
    <!-- banner-->
	<div class="banner">
		<div class="welcome_msg">
			<h1>Security Suite</h1>
		</div>


	</div>

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
			<br><br>
            <p>Choose the tool you need</p>
            <select name="tools">
				 <option value="" selected hidden>--Action-- </option>
                <option value="1">Twitter Scraper</option>
				 </select>
				 <br>
			<button class = "btn" onclick="registered()" type='submit' name="register">Register Details</button>
        </form>
        <br><br>
        <p>Already a member?</p>
        <br>
        <button id="signButton" class = "btn" name="signBtn">Sign in</button>
    </div>
</div>
	
    
<?php

  // Get the posted information

    $Email		 = mysqli_real_escape_string($conn, $_POST['email']);
    $Password      = mysqli_real_escape_string($conn, $_POST['password']);
    $Password2      = mysqli_real_escape_string($conn, $_POST['password2']);
    $Username      = mysqli_real_escape_string($conn, $_POST['username']);
    $Tool     = mysqli_real_escape_string($conn, $_POST['tools']);
    
    
    
    if (isset($_POST['register'])){
        if ($Password != $Password2) {
            echo '<p align="center">'.'Passwords do not match.  Please try again.'.'</p>';
        } 
        else {
            //        Get user info
            if($Email != "") {
                
                $Query = "SELECT * FROM Users WHERE Username = '$Username'";
                $Result = mysqli_query($conn,$Query); 
                $NumResults = mysqli_num_rows($Result); 
                
                if ($NumResults == 1){
                    //Checks if username is already created.
                    echo 'Username already exists.  Please try a different name.';
                    echo "<br>";
                    echo "<br>";
                    echo "<input TYPE='submit' VALUE='Register'>";
                }
                else {
                    $Username = addslashes($Username);
                    $_SESSION["Name"] = $Username;
                    $_SESSION["Mail"] = $Email;
                    $_SESSION["Pass"] = $Password;
                    $_SESSION["Tool"] = $Tool;
                
                    $usermail		 = $_SESSION["Mail"];
                    $userpass      = $_SESSION["Pass"];
                    $nameuser      = $_SESSION["Name"];
                    $tools      = $_SESSION["Tool"];
            
                    //Hash the password
                    $hashed_password = password_hash($userpass, PASSWORD_DEFAULT);
            
                    // Inserts data into User table
                    if($usermail != ""){   
                        $arr = array('God.png', 'Oogene.png', 'profile.png', 'Blobby.png', 'Djason.png', 'Elijah.png', 'Micro.png');
                        $randimg = mt_rand(1, 7);  //	 array to add random image for avatar.
                
                        $Query = "INSERT INTO Users (Username, Email, Password, Image, Tools) VALUES ('$nameuser','$usermail', '$hashed_password', '$arr[$randimg]', '$tools')";
                        $Result = mysqli_query($conn,$Query); 	
                
                        if ($Result == true){           
                            header("Location:index.php");
                        }
                        else if($Result == false){
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
            location.href = "https://comp-hons.uhi.ac.uk/~15009351/Scraperwebsite/index.php";
        }
    } catch (signerr) {
         document.getElementsByName("signBtn").innerHTML = opTerr.message;
    }
    
</script>        
        
	
<!-- Footer -->
<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->