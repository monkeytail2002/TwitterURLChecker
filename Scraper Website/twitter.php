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
    <div class="container">        
        
            <!-- banner with log in-->
        <div class="banner">
            <div class="welcome_msg">
                <h1>Security Suite</h1>
            </div>
        </div>
            
        						<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
        
        <div class="content">
        <?php

//Get the user input and store it as a variable
        $search = $_POST['twitterSearch'];
        $_SESSION['userInput'] = $search;

//Run the python script with the user inout and return the list.
        $pythonReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/twitterscrape.py '$search'");
        //~ echo '<p>'.$pythonReturn.'</p>';
//Put the returned list into a usable format for PHP, trimming off the various unnecessary parts
   	    $pythonReturn = str_replace(array("u'","[","]"), array(""), $pythonReturn);
 	    $strToPHPArray = str_getcsv($pythonReturn, ",");
        $retUrl1  = trim($strToPHPArray[0], "'");
        $retUrl2 = trim($strToPHPArray[1], "'");
        $retUrl3 = trim($strToPHPArray[2], "'");
        $retUrl4 = trim($strToPHPArray[3], "'");

//Set the returned URL's to variables.
        $_SESSION["URL1"] = $retUrl1;
        $_SESSION["URL2"] = $retUrl2;
        $_SESSION["URL3"] = $retUrl3;
        $_SESSION["URL4"] = $retUrl4;

//Test the returned variables
        //~ echo '<p>'.$retUrl1.'</p>';
        //~ echo '<p>'.$retUrl2.'</p>';
        //~ echo '<p>'.$retUrl3.'</p>';
        //~ echo '<p>'.$retUrl4.'</p>';

//Test the array output
//        print_r($strToPHPArray);


//Displays the URL's returned
        if ($retUrl1 || $retUrl2 || $retUrl3 || $retUrl4){
		?>

            <center><h1>Submit URLs</h1></center>
            <br>
            <center><p>Due to API usage limitations, only the four most recent URL's can be returned.</p></center>
            <br>
            <center><p>Returned URL's for: <?php echo '<p>'.$search.'</p>'; ?></p></center>
            <br>

<?php
            echo '<center>'.'<p>'.$retUrl1.'</p>'.'</center>';
            echo '<center>'.'<p>'.$retUrl2.'</p>'.'</center>';
            echo '<center>'.'<p>'.$retUrl3.'</p>'.'</center>';
            echo '<center>'.'<p>'.$retUrl4.'</p>'.'</center>';
            
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
