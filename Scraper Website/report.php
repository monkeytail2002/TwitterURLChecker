<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
8/4/2020
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

<title>Twitter Reports | Security Suite</title>
    </head>
<body>
	<div class="container">
        
        
        <!-- banner-->
        <div class="banner">
            <div class="welcome_msg">
                <center><h1>Twitter Scraper Reports</h1></center>
            </div>
        </div>
        
                <!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
        
        <div class="content">
            <center><p>Please choose the sandbox report that you need</p></center>
            <div style="width: 40%; margin: 20px auto;">
                <center><form method="post" action="report.php">
                    <select name="reports">
                        <option value="" selected hidden>--Action-- </option>
                        <option value="1">VirusTotal</option>
                        <option value="2">URLScan</option>
                    </select>
				 <br>
                    <button class = "btn" type='submit'>Select Report</button>
                    </form></center>
            </div>
            
        <?php

//            Go to required tool
            $Report = mysqli_real_escape_string($conn, $_POST['reports']);
//            echo $Report;
           
            if ($Report == '1'){
                header("Location:VirusTotal.php");
            } else if ($Report == '2'){
                header("Location:URLScan.php");
            } 
            
            ?>
            
        </div>
        
        
    </div>
    
    <script>
    
    //Script for opening the nav menu 
	
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