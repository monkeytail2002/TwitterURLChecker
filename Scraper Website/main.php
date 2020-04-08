<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
02/4/2020
-->

<!--Required modules-->

<?php require_once('config.php'); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php'); ?>

<!--Checks if user session is valid-->
<?php
    if($_SESSION['Valid']){
    } else {
        header("Location:index.php");
    } ?>

    <title>Twitter Search | Security Suite</title>
</head>
<body>
    
	<div class="container">
        
        <div class="banner">
            <div class="welcome_msg">
                <h1>Security Suite</h1>
            </div>
        </div>
		
						<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
		
		
 
        <h1><center>Twitter Tool</center></h1>
        <br><br>
        <h2><center>Enter the term to search and press enter</center></h2>
        <br>
<!--        Takes the search term from the user-->
        <center><form action="twitter.php" method="post">
            <input type="text" name="twitterSearch">
        </form>
        </center>
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
    
		<!-- Include Footer page -->
<?php include('includes/footer.php') ?>