<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
13/4/2020
-->

<!--Requried modules-->
<?php require_once('config.php'); ?>
<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>


<?php
// Checks if session is valid
if($_SESSION["Valid"]){
	} else {
	header("Location:index.php");
} ?>



	<title>Dashboard | Security Suite</title>
</head>
<body>
		
	<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>

	
	<section class = "main">
		<aside>
			<div class = "Display Users">
				<h2 class="content-title">Manage Users</h2>
				<hr>
			<!--		Displays usernames and emails.-->
				
				<table border = "1">
					<tr>
						<th >Username</th>
						<th >Email</th>
						<th>Details</th>
					</tr>
		
		<?php 
			
					$Query = "SELECT * FROM Users ORDER BY Username ASC";
					$result = mysqli_query($conn,$Query);
					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
						if($row['Suspended'] == 1 && $row['Role'] == 2) {
							echo "<td>".$row['Username']."</td>";
							echo "<td>".$row['Email']."</td>";
							echo "<td>"."Admin User"."</td>";
						} else if ($row['Suspended'] == 2 && $row['Role'] == 1){
							echo "<td>".$row['Username']."</td>";
							echo "<td>".$row['Email']."</td>";
							echo "<td>"."Suspended User"."</td>";
						} else if ($row['Suspended'] == 1 && $row['Role'] == 1){
							echo "<td>".$row['Username']."</td>";
							echo "<td>".$row['Email']."</td>";
							echo "<td>".""."</td>";
						} 
						echo "</tr>";
					}
		
		
		
		?>
		
				</table>
		

	
			</div>
		</aside>
	
	
	
		<aside>
		
			<!--	Manage User function-->
	 		<div class="Manage Users">
				<h1>Manage Users</h1>
				<div ng-app="Myapp" ng-controller="MyController">
					<form method="POST" action="manage.php">
						<p>Select user: </p>
						<select name = "userlist" ng-init="getdetails()">
							<option value="" selected hidden>--Username-- </option>
							<option ng-repeat="users in Username" name={{users.Username}}>{{users.Username}}</option>	 
						</select>
						<br>
						<p>Select Action:</p>
<!--					Select action to perform promote/suspend-->
						<select name="actionlist">
							<option value="" selected hidden>--Action-- </option>
							<option value="1">Promote</option>
							<option value="2">Suspend</option>
						</select>
						<br>
						<button class="btn" type="submit" ng-click="update(users.Username)" name="login_btn">Submit</button>
					</form>
				</div>			 
			</div>
		</aside>
	</section>
	
	
	<script>
		
	
        //	script to populate select menus with database information.

		try {
			var app = angular.module("Myapp",[]);
			app.controller("MyController", function($scope, $http) {
				$scope.getdetails=function() {
					$http.get("ang_user.php")
						.success(function(data) {
						$scope.Username=data;
					});
				}
			});
		} catch (droperr){
			alert("Error in dropdown");
		}
        
        
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
	
<?php require_once( ROOT_PATH . '/includes/footer.php') ?>
