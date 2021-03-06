<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
28/4/2020
-->

<!--Required modules-->

<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>

<title>Contacts | Security Suite</title>

</html>
<body>

	<div class="container">
        
        	
	<!-- Calls in Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
        
        
        <div class="content">
            <h2 class="content-title">Site Administrator</h2>
            <hr>

<!--Site contact information-->

			<img id = "monkey" src="<?php $avatar = "SELECT Image FROM Users WHERE UserId = 1"; $result = mysqli_query($conn,$avatar); $row = mysqli_fetch_array($result); $profile_pic = $row['Image'];  echo BASE_URL . '/static/images/' . $profile_pic; ?>" alt="" class="profile_pic" height ="50", width = "50">
            <p>Angus MacDonald is the site administrator.  If there are any issues with the website then please contact Angus and let him know.</p>
            <br>
            
            <p>Email information: 15009351@uhi.ac.uk</p>
        </div>

	</div>

	

</body>
</html>

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
