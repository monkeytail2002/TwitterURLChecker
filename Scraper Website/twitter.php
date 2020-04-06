<!--Required modules-->
<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/logout.php') ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>

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
            
        <div class="content">
        <?php

//Get the user input and store it as a variable
        $search = $_POST['twitterSearch'];

//Run the python script with the user inout and return the list.
        $pythonReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/twitterscrape.py '$search'");

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
//        echo '<p>'.$retUrl1.'</p>';
//        echo '<p>'.$retUrl2.'</p>';
//        echo '<p>'.$retUrl3.'</p>';
//        echo '<p>'.$retUrl4.'</p>';

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
            echo '<center>'.'<p>'.'URL returned: '.$retUrl1.'</p>'.'</center>'.'<br>';
            echo '<center>'.'<p>'.'URL returned: '.$retUrl2.'</p>'.'</center>'.'<br>';
            echo '<center>'.'<p>'.'URL returned: '.$retUrl3.'</p>'.'</center>'.'<br>';
            echo '<center>'.'<p>'.'URL returned: '.$retUrl4.'</p>'.'</center>'.'<br>';
        }


?>
        </div>
    </div>



   <script>

   //    function sandboxWait(){
     //       location.replace("/update.php")
      //  }

    </script>
		<!-- Include Footer page -->
<?php include('includes/footer.php') ?>
