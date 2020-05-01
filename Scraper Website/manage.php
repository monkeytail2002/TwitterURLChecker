<?php require_once('config.php');?>
<?php require_once( ROOT_PATH . '/includes/head_section.php'); ?>

<!--Checks to see if user session is valid-->
<?php
if($_SESSION["Valid"]){
	} else {
	header("Location:index.php");
} ?>


<title>Admin | Manage Users</title>
</head>
<body>
	
		<div class="container">
	
			<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>

			
<?php

$action = mysqli_real_escape_string($conn,$_POST['actionlist']);
$userlist = mysqli_real_escape_string($conn,$_POST['userlist']);
$_SESSION['post'] = $postaction;
$seshid = $_SESSION['UserId'];
$_SESSION['promuser'] = $userlist;

//Manages user details from the admin dashboard
	
	
			if($action == 1){ 
            ?>
			
<!--            form to promote users-->
			
		<form method="POST" action="update.php">
				<p>Promote/Demote User?</p>
			<br>
				 Are you sure you wish to promote/demote <?php echo $userlist; ?>
				 <select name="promote">
				 <option value="" selected hidden>--Select-- </option>
				 <option value="1">Promote</option>
				 <option value="2">Demote</option>
				 </select>
				 <br>
				 <input type="submit" value="Submit" />
	</form>

<?php 			
		} else if($action == 2){ 
            ?>
			
<!--	Form to suspend/unsuspend users-->
			
			<form method="POST" action="update.php">
				<p>Suspend/Unsuspend User?</p>
				<br>
				Are you sure you want to suspend/unsuspend <?php echo $userlist; ?>
				 <select name="suspend">
				 <option value="" selected hidden>--Select-- </option>
				 <option value="1">Suspend</option>
				 <option value="2">Unsuspend</option>
				 </select>
				 <br>
				 <input type="submit" value="Submit" />
	</form>
            <?php
            }
?>
	</div>


<?php require_once( ROOT_PATH . '/includes/footer.php') ?>

	<script>  
//	Scripts to control navbar

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
