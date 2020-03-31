<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
31/3/2020
-->


<div class="navbar">

	<?php

	$role = $_SESSION["UserLevel"];
	$logged = $_SESSION["UserName"];
//Checks if user is logged in
	if($logged == true){
        
		?>
	
		<div class="logo_div">
            <a href="Main.php"><h1>Security Suite</h1></a>
            <span ontouchstart="openTouch(e)" onclick="openNav()"> 
                <div class="navbg">
                    <div class="bar1"></div>
					<div class="bar2"></div>
					<div class="bar3"></div>
				</div>
			</span>
		</div>
		<?php
//		Checks user role and displays menu based on user role.
		if($role == 1){ ?>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" ontouchstart="closeTouch(e)"  onclick="closeNav()">&times;</a>
                <a href="Main.php">Home</a>
                <a href="account.php">Account</a>
                <a href="contacts.php">Contact</a>
                <a href="index.php">Log Out</a>
            </div>
        
	<?php
        } else if($role == 2){ ?>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" ontouchstart="closeTouch(e)"  onclick="closeNav()">&times;</a>
                <a href="Main.php">Home</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="account.php">Account</a>
                <a href="contacts.php">Contact</a>
                <a href="index.php">Log Out</a>
            </div>
		
		<?php
	   }
	} 

	
	?>

</div>