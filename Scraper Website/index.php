<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
31/3/2020
-->

<!--Call in required modules-->
	<?php require_once('config.php') ?>
	<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	<?php require_once( ROOT_PATH . '/includes/logout.php') ?>


	<title>Sign in | Security Suite </title>
</head>
<body>
	
		<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	
	
	<div class="container">
		       
		
        <!-- Page content -->
        <div class="content">
            <h2 class="content-title">User verification required to see results.</h2>
            <div class="login_div">
                <form action="verify.php" method="post" >
                    <br>
                    <br>
                    <h2>Login</h2>
                    <br><br>
                    <p>Username: </p><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
                    <p>Password: </p><input type="password" name="password"  placeholder="Password"> 
                    <br>
                    <button class="btn" type="submit" name="login_btn">Sign in</button>
                </form>
                <br><br>
                <p>If you are not registered then click register:</p>
                <button id="registerButton" class="btn">Register</button>
            </div>
        </div>
	</div>
    
<!--script to direct register button.-->
	<script type="text/javascript">
		document.getElementById("registerButton").onclick = function () {
			location.href = "http://securitysuite.scot/register.php";
		}
    
	</script>
        
        
<?php require_once( ROOT_PATH . '/includes/footer.php') ?>
