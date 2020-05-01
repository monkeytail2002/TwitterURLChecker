<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
5/4/2020
-->

<!--Required modules-->
<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>

<?php
    if($_SESSION['Valid']){
    } else {
        header("Location:index.php");
    } ?>

<title>Twitter Search | Security Suite</title>
</head>
<body>
	    
	<div class ="container">
		
		        						<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>

		<div class="content">
			<?php

	//Get the user input and store it as a variable
			$search = $_POST['twitterSearch'];
			$_SESSION['userInput'] = $search;

		//Run the python script with the user inout and return the list.
			$python_return = shell_exec("python /home/anmacdon/Desktop/Scraper/twitterscrape.py '$search'");

		//Put the returned list into a usable format for PHP, trimming off the various unnecessary parts
			$python_return = str_replace(array("u'","[","]"), array(""), $python_return);
			$str_to_php_array = str_getcsv($python_return, ",");
			$retuned_url_1  = trim($str_to_php_array[0], "'");
			$retuned_url_2 = trim($str_to_php_array[1], "'");
			$retuned_url_3 = trim($str_to_php_array[2], "'");
			$retuned_url_4 = trim($str_to_php_array[3], "'");

	//Set the returned URL's to variables.
			$_SESSION["URL1"] = $retuned_url_1;
			$_SESSION["URL2"] = $retuned_url_2;
			$_SESSION["URL3"] = $retuned_url_3;
			$_SESSION["URL4"] = $retuned_url_4;

	//Displays the URL's returned
			if ($retuned_url_1 || $retuned_url_2 || $retuned_url_3 || $retuned_url_4){
				?>

				<center><h1>Submit URLs</h1></center>
				<br>
				<center><p>Due to API usage limitations, only the four most recent URL's can be returned.</p></center>
				<br>
				<center><p>Returned URL's for: <?php echo '<p>'.$search.'</p>'; ?></p></center>
				<br>

		<?php
				echo '<center>'.'<p>'.$retuned_url_1.'</p>'.'</center>';
				echo '<center>'.'<p>'.$retuned_url_2.'</p>'.'</center>';
				echo '<center>'.'<p>'.$retuned_url_3.'</p>'.'</center>';
				echo '<center>'.'<p>'.$retuned_url_4.'</p>'.'</center>';

					?>
				<br>
				<center><p>Submit to sandboxes?</p></center>
				<br>
				<center><p>Please note that it can take up to 20 minutes to return results due to the sandbox processing time.</p></center>
				<br>
		<!--            Button for submission-->
				<center><button class = "btn" onclick="sandboxSubmit()" type='submit'>Submit</button></center>

				<?php    
			}           
					?>




		</div>
	</div>



   <script>
//       Function that sends to update.php when submission button is pressed.
       try{
           function sandboxSubmit(){
               location.href = "http://securitysuite.scot/update.php";
           }
       } catch(submitErr){
            document.getElementById("sandboxSubmit").innerHTML = openerr.message;
       }
       
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
