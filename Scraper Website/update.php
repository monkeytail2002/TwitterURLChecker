<!--Required modules-->
<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>

<!--Checks if user session is valid-->
<?php
    if($_SESSION['Valid']){
    } else {
        header("Location:index.php");
    } ?>
</head>
<body>
<?php
    
    $retUrl1 = $_SESSION["URL1"];
    $retUrl2 = $_SESSION["URL2"];
    $retUrl3 = $_SESSION["URL3"];
    $retUrl4 = $_SESSION["URL4"];
    
    if ($retUrl1 == true){
        //Run the python script for VirusTotal
        $VTReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl1'");
        
        //Put the returned list into a usable format for PHP, trimming off the various unnecessary parts
   	    $VTReturn = str_replace(array("u'","[","]"), array(""), $VTReturn);
 	    $strToPHPArray = str_getcsv($VTReturn, ",");
        $reportLink1 = trim($strToPHPArray[0], "{permalink': ");
        $scanId1 = trim($strToPHPArray[5], "scan_id': ");
        $positives1 = trim($strToPHPArray[9], "positives': ");
        $total1 = trim($strToPHPArray[10], "total': ");
        
        //test the results are coming through correctly
//        echo '<p>'.$reportLink1.'</p>';
//        echo '<p>'.$scanId1.'</p>';
//        echo '<p>'.$positives1.'</p>';
//        echo '<p>'.$total1.'</p>';
    }
    
//    if ($retUrl2 == true){
//        //Run the python script for VirusTotal
//        $VTReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl2'");
//    }
//    
//    if ($retUrl3 == true){
//        //Run the python script for VirusTotal
//        $VTReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl3'");
//    }
//    
//    if ($retUrl4 == true){
//        //Run the python script for VirusTotal
//        $VTReturn = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl4'");
//    }


?>
    
    <?php include('includes/footer.php') ?>