<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
08/4/2020
-->

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
    
    //Set variables
    
    //User input from twitter search
    $userInput = $_SESSION['userInput'];
    
    //URL's from returned Twitter search
    $retUrl1 = $_SESSION["URL1"];
    $retUrl2 = $_SESSION["URL2"];
    $retUrl3 = $_SESSION["URL3"];
    $retUrl4 = $_SESSION["URL4"];
    
    if ($retUrl1 || $retUrl2 || $retUrl3 || $retUrl4 == true){
        //Run the python script for VirusTotal
        $VTReturn1 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl1'");
        $VTReturn2 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl2'");



        //Put the returned list into a usable format for PHP, trimming off the various unnecessary parts
//   	    retUrl1
        $VTReturn1 = str_replace(array("u'","[","]"), array(""), $VTReturn1);
 	    $strToPHPArray1 = str_getcsv($VTReturn1, ",");
        $reportLink1 = trim($strToPHPArray1[0], "{permalink': ");
        $positives1 = trim($strToPHPArray1[9], "positives': ");
        $total1 = trim($strToPHPArray1[10], "total': ");
        
//        retUrl2
        $VTReturn2 = str_replace(array("u'","[","]"), array(""), $VTReturn2);
 	    $strToPHPArray2 = str_getcsv($VTReturn2, ",");
        $reportLink2 = trim($strToPHPArray2[0], "{permalink': ");
        $positives2 = trim($strToPHPArray2[9], "positives': ");
        $total2 = trim($strToPHPArray2[10], "total': ");
        
            
//        test the results are coming through correctly
//        echo '<p>'.$reportLink1.'</p>';
//        echo '<p>'.$positives1.'</p>';
//        echo '<p>'.$total1.'</p>';
//        
//                test the results are coming through correctly
//        echo '<p>'.$reportLink2.'</p>';
//        echo '<p>'.$positives2.'</p>';
//        echo '<p>'.$total2.'</p>';
//        
//        echo '<p>'.$userInput.'</p>';

        
//        Insert for retUrl1
        if ($positives1 == 0){
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$total1','$reportLink1', CURDATE(), '$reportLink1', '$userInput', '$retUrl1')";
//            print($query)
            $Result = mysqli_query($conn,$query);
        }
        else {
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$total1','$reportLink1', CURDATE(), '$reportLink1', '$userInput', '$retURL1')";
            $Result = mysqli_query($conn,$query);
        }
    
//        Insert for retUrl2
        if ($positives2 == 0){
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$total2','$reportLink2', CURDATE(), '$reportLink2', '$userInput', '$retUrl2')";
//            print(query);
            $Result = mysqli_query($conn,$query);
        }
        else {
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$total2','$reportLink2', CURDATE(), '$reportLink2', '$userInput', '$retUrl2')";
            $Result = mysqli_query($conn,$query);
        }
        
        //Since python can only be run twice, the program will be told to wait a minute before running the other two URL's.  This should be possible since php reads top down.
        
        sleep(60);
            
        $VTReturn3 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl3'");
        $VTReturn4 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$retUrl4'");
        
        
        //        retUrl3
        $VTReturn3 = str_replace(array("u'","[","]"), array(""), $VTReturn3);
 	    $strToPHPArray3 = str_getcsv($VTReturn3, ",");
        $reportLink3 = trim($strToPHPArray3[0], "{permalink': ");
        $positives3 = trim($strToPHPArray3[9], "positives': ");
        $total3 = trim($strToPHPArray3[10], "total': ");
        
//        retUrl4
        $VTReturn4 = str_replace(array("u'","[","]"), array(""), $VTReturn4);
 	    $strToPHPArray4 = str_getcsv($VTReturn4, ",");
        $reportLink4 = trim($strToPHPArray4[0], "{permalink': ");
        $positives4 = trim($strToPHPArray4[9], "positives': ");
        $total4 = trim($strToPHPArray4[10], "total': ");
        
            
        //        Insert for retUrl3
        if ($positives3 == 0){
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$total3','$reportLink3', CURDATE(), '$reportLink3', '$userInput', '$retUrl3')";
            $Result = mysqli_query($conn,$query);
            
        }else {
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$total3','$reportLink3', CURDATE(), '$reportLink3', '$userInput', '$retUrl3')";
            $Result = mysqli_query($conn,$query);
        }
        
        //        Insert for retUrl4
        if ($positives4 == 0){
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$total4','$reportLink4', CURDATE(), '$reportLink4', '$userInput', '$retUrl4')";
            $Result = mysqli_query($conn,$query);
        }else {
            $query = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$total4','$reportLink4', CURDATE(), '$reportLink4', '$userInput', '$retUrl4')";
            $Result = mysqli_query($conn,$query);
        }
//        Allow some time for the python scripts to run.
        sleep(60);
            
//            Redirect to report.php
        header('Location: http://securitysuite.scot/report.php' );       

    
    }
    
?>
    
    <?php include('includes/footer.php') ?>
