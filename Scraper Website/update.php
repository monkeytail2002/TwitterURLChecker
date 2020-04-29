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
    $user_input = $_SESSION['userInput'];
    
    //URL's from returned Twitter search
    $returned_URL_1 = $_SESSION["URL1"];
    $returned_URL_2 = $_SESSION["URL2"];
    $returned_URL_3 = $_SESSION["URL3"];
    $returned_URL_4 = $_SESSION["URL4"];
    
    if ($returned_URL_1 || $returned_URL_2 || $returned_URL_3 || $returned_URL_4 == true){
  
        //Run the python scripts for VirusTotal and URLScan
        $VT_Return_1 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$returned_URL_1'");
        $URL_Return_1 = shell_exec("python /home/anmacdon/Desktop/Scraper/URLSearch.py '$returned_URL_1'");

        //Turn the returned values into csv format which can be used by php
        $VT_Return_1 = str_replace(array("u'","[","]"), array(""), $VT_Return_1);
 	    $VT_str_array_1 = str_getcsv($VT_Return_1, ",");
        $URL_Return_1 = str_replace(array("u'","[","]"), array(""), $URL_Return_1);
        $URL_str_array_1 = str_getcsv($URL_Return_1, ",");
        
        //Trim the required values and store them in variables
        $VT_report_link_1 = trim($VT_str_array_1[0], "{permalink': ");
        $VT_positives_1 = trim($VT_str_array_1[9], "positives': ");
        $VT_total_1 = trim($VT_str_array_1[10], "total': ");
        $urlscan_verdict_1 = trim($URL_str_array_1[1], "malicious': ");
        $urlscan_score_1 = trim($URL_str_array_1[2], "score': ");
        $overall_verdict_1 = trim($URL_str_array_1[7], "malicious': ");
        $engines_score_1 = trim($URL_str_array_1[23], "score': ");
        $engines_total_1 = trim($URL_str_array_1[25], "enginesTotal': }}");
        $engines_verdict_1 = trim($URL_str_array_1[21], "malicious': ");
        $community_verdict_1 = trim($URL_str_array_1[15], "votesMalicious': ");
        $community_score_1 = trim($URL_str_array_1[16], "score': ");
        $URL_report_1 = trim($URL_str_array_1[35], "reportURL': '");

//~ //        Insert for returned_URL_1

//~ //          VirusTotal insert
        if (VT_positives_1  == 0){
            $VT_Insert_1 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$VT_total_1','$VT_report_link_1', CURDATE(), '$VT_report_link_1', '$user_input', '$returned_URL_1')";
            $Result = mysqli_query($conn,$VT_Insert_1);
            if($Result){
                $Get_VT_Report_Id_1 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_1'";
                $Result = mysqli_query($conn,$Get_VT_Report_Id_1);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_1 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_1"] = $VT_Scan_Id_1;
            }
        }
        else {
            $VT_Insert_1 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$VT_total_1','$VT_report_link_1', CURDATE(), '$VT_report_link_1', '$user_input', '$returned_URL_1')";
            $Result = mysqli_query($conn,$VT_Insert_1);
            if($Result){
                $Get_VT_Report_Id_1 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_1'";
                $Result = mysqli_query($conn,$Get_Report_Id_1);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_1 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_1"] = $VT_Scan_Id_1;
                $VT_Scan_Id_1 = $_SESSION["VT_Scan_Id_1"];
            }
        }
    
        
        //URLScan insert
        if($urlscan_score_1|| $engines_score_1 || $community_score_1 == 0){
            $URL_Results_Insert_1 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_1', '$community_score_1','$urlscan_verdict_1','$urlscan_score_1','$engines_verdict_1','$engines_total_1','$engines_score_1','$overall_verdict_1')";
            $Result = mysqli_query($conn,$URL_Results_Insert_1);
            
            if($Result == true){
                $Get_URL_Report_Id_1 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_1);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_1 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_1= "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('0','$URL_report_1',CURDATE(),'$URL_report_1','$user_input','$returned_URL_1','$URL_Report_Id_1')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_1);
                    
                    if($Result){
                            $URL_Scan_Id_1= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_1'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_1);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_1 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_1"] = $URLScan_Id_1;

                        }
                }
            }
        } else {
            $URL_Results_Insert_1 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_1', '$community_score_1','$urlscan_verdict_1','$urlscan_score_1','$engines_verdict_1','$engines_total_1','$engines_score_1','$overall_verdict_1')";
            $Result = mysqli_query($conn,$URL_Results_Insert_1);
            
            if($Result == true){
                $Get_URL_Report_Id_1 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_1);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_1 = $Row['URLResultId'];
                                
                if($Result == true){
                    $URL_Scan_Insert_1= "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('1','$URL_report_1',CURDATE(),'$URL_report_1','$user_input','$returned_URL_1','$URL_Report_Id_1')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_1);
                    
                    if($Result){
                            $URL_Scan_Id_1= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_1);
                            $Row = mysqli_fetch_assoc($Result);
                            $_SESSION['URL_Scan_Id_1'] = $Row['URLScanId'];
                    }
                }
            }
        }
        
            $VT_Scan_Id_1 = $_SESSION["VT_Scan_Id_1"];
            $URLScan_Id_1 = $_SESSION["URL_Scan_Id_1"];
        
        if($VT_Scan_Id_1 && $URLScan_Id_1 == true){
            $Scan_Insert_1 = "INSERT INTO Scan(VTScanId, URLScanId, URLSearched, ScanDate) VALUES ('$VT_Scan_Id_1', '$URLScan_Id_1', '$returned_URL_1', CURDATE())";
            $Result = mysqli_query($conn,$Scan_Insert_1);
            
            if($Result){
                $Scan_Select_1 = "SELECT ScanId FROM Scan WHERE VTScanId = '$VT_Scan_Id_1' && URLScanId = '$URLScan_Id_1'";
                $Result = mysqli_query($conn,$Scan_Select_1);
                $Scan_row_1 = mysqli_fetch_assoc($Result);
                $Scan_Id_1 = $Scan_row_1['ScanId'];
                
                if($Result){
                    $Tool_Scan_Insert_1 = "INSERT INTO Tool_Scan(ToolId, ScanId) VALUES ('1', '$Scan_Id_1')";
                    $Result = $Result = mysqli_query($conn,$Tool_Scan_Insert_1);
                }
            }
        }

     //Run the python scripts for VirusTotal and URLScan
        $VT_Return_2 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$returned_URL_2'");
        $URL_Return_2 = shell_exec("python /home/anmacdon/Desktop/Scraper/URLSearch.py '$returned_URL_2'");

        //Turn the returned values into csv format which can be used by php
        $VT_Return_2 = str_replace(array("u'","[","]"), array(""), $VT_Return_2);
 	    $VT_str_array_2 = str_getcsv($VT_Return_2, ",");
        $URL_Return_2 = str_replace(array("u'","[","]"), array(""), $URL_Return_2);
        $URL_str_array_2 = str_getcsv($URL_Return_2, ",");
        
        //Trim the required values and store them in variables
        $VT_report_link_2 = trim($VT_str_array_2[0], "{permalink': ");
        $VT_positives_2 = trim($VT_str_array_2[9], "positives': ");
        $VT_total_2 = trim($VT_str_array_2[10], "total': ");
        $urlscan_verdict_2 = trim($URL_str_array_2[1], "malicious': ");
        $urlscan_score_2 = trim($URL_str_array_2[2], "score': ");
        $overall_verdict_2 = trim($URL_str_array_2[7], "malicious': ");
        $engines_score_2 = trim($URL_str_array_2[23], "score': ");
        $engines_total_2 = trim($URL_str_array_2[25], "enginesTotal': }}");
        $engines_verdict_2 = trim($URL_str_array_2[21], "malicious': ");
        $community_verdict_2 = trim($URL_str_array_2[15], "votesMalicious': ");
        $community_score_2 = trim($URL_str_array_2[16], "score': ");
        $URL_report_2 = trim($URL_str_array_2[35], "reportURL': '");
    
   
 //        Insert for returned_URL_2

//          VirusTotal insert
        if (VT_positives_2  == 0){
            $VT_Insert_2 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$VT_total_2','$VT_report_link_2', CURDATE(), '$VT_report_link_2', '$user_input', '$returned_URL_2')";
            $Result = mysqli_query($conn,$VT_Insert_2);
            if($Result){
                $Get_VT_Report_Id_2 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_2'";
                $Result = mysqli_query($conn,$Get_VT_Report_Id_2);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_2 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_2"] = $VT_Scan_Id_2;
            }
        }
        else {
            $VT_Insert_2 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$VT_total_2','$VT_report_link_2', CURDATE(), '$VT_report_link_2', '$user_input', '$returned_URL_2')";
            $Result = mysqli_query($conn,$VT_Insert_2);
            if($Result){
                $Get_VT_Report_Id_2 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_2'";
                $Result = mysqli_query($conn,$Get_Report_Id_2);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_2 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_2"] = $VT_Scan_Id_2;
            }
        }
    
        
        //URLScan insert
        if($urlscan_score_2 || $engines_score_2 || $community_score_2 == 0){
            $URL_Results_Insert_2 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_2', '$community_score_2','$urlscan_verdict_2','$urlscan_score_2','$engines_verdict_2','$engines_total_2','$engines_score_2','$overall_verdict_2')";
            $Result = mysqli_query($conn,$URL_Results_Insert_2);
            
            if($Result == true){
                $Get_URL_Report_Id_2 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_2);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_2 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_2 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('0','$URL_report_2',CURDATE(),'$URL_report_2','$user_input','$returned_URL_2','$URL_Report_Id_2')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_2);
                    
                    if($Result){
                            $URL_Scan_Id_2= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_2'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_2);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_2 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_2"] = $URLScan_Id_2;

                        }
                }
            }
        } else {
            $URL_Results_Insert_2 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_2', '$community_score_2','$urlscan_verdict_2','$urlscan_score_2','$engines_verdict_2','$engines_total_2','$engines_score_2','$overall_verdict_2')";
            $Result = mysqli_query($conn,$URL_Results_Insert_2);
            
            if($Result == true){
                $Get_URL_Report_Id_2 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_2);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_2 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_2 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('1','$URL_report_2',CURDATE(),'$URL_report_2','$user_input','$returned_URL_2','$URL_Report_Id_2')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_2);
                    
                    if($Result){
                            $URL_Scan_Id_2= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_2'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_2);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_2 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_2"] = $URLScan_Id_2;         
                    }
                }
            }
        }
        
            $VT_Scan_Id_2 = $_SESSION["VT_Scan_Id_2"];
            $URLScan_Id_2 = $_SESSION["URL_Scan_Id_2"];
        
        if($VT_Scan_Id_2 && $URLScan_Id_2 == true){
            $Scan_Insert_2 = "INSERT INTO Scan(VTScanId, URLScanId, URLSearched, ScanDate) VALUES ('$VT_Scan_Id_2', '$URLScan_Id_2', '$returned_URL_2', CURDATE())";
            $Result = mysqli_query($conn,$Scan_Insert_2);
            
            if($Result){
                $Scan_Select_2 = "SELECT ScanId FROM Scan WHERE VTScanId = '$VT_Scan_Id_2' && URLScanId = '$URLScan_Id_2'";
                $Result = mysqli_query($conn,$Scan_Select_2);
                $Scan_row_2 = mysqli_fetch_assoc($Result);
                $Scan_Id_2 = $Scan_row_2['ScanId'];
                
                if($Result){
                    $Tool_Scan_Insert_2 = "INSERT INTO Tool_Scan(ToolId, ScanId) VALUES ('1', '$Scan_Id_2')";
                    $Result = mysqli_query($conn,$Tool_Scan_Insert_2);
                }
            }
        }
        

        
        sleep(60);
    //Run the python scripts for VirusTotal and URLScan
        $VT_Return_3 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$returned_URL_3'");
        $URL_Return_3 = shell_exec("python /home/anmacdon/Desktop/Scraper/URLSearch.py '$returned_URL_3'");
        
        //Turn the returned values into csv format which can be used by php
        $VT_Return_3 = str_replace(array("u'","[","]"), array(""), $VT_Return_3);
 	    $VT_str_array_3 = str_getcsv($VT_Return_3, ",");
        $URL_Return_3 = str_replace(array("u'","[","]"), array(""), $URL_Return_3);
        $URL_str_array_3 = str_getcsv($URL_Return_3, ",");
        
        
        //Trim the required values and store them in variables
        $VT_report_link_3v= trim($VT_str_array_3[0], "{permalink': ");
        $VT_positives_3 = trim($VT_str_array_3[9], "positives': ");
        $VT_total_3 = trim($VT_str_array_3[10], "total': ");
        $urlscan_verdict_3 = trim($URL_str_array_3[1], "malicious': ");
        $urlscan_score_3 = trim($URL_str_array_3[2], "score': ");
        $overall_verdict_3 = trim($URL_str_array_3[7], "malicious': ");
        $engines_score_3 = trim($URL_str_array_3[23], "score': ");
        $engines_total_3 = trim($URL_str_array_3[25], "enginesTotal': }}");
        $engines_verdict_3 = trim($URL_str_array_3[21], "malicious': ");
        $community_verdict_3 = trim($URL_str_array_3[15], "votesMalicious': ");
        $community_score_3 = trim($URL_str_array_3[16], "score': ");
        $URL_report_3 = trim($URL_str_array_3[35], "reportURL': '");
    
 //        Insert for returned_URL_3

//          VirusTotal insert
        if (VT_positives_3  == 0){
            $VT_Insert_3 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$VT_total_3','$VT_report_link_3', CURDATE(), '$VT_report_link_3', '$user_input', '$returned_URL_3')";
            $Result = mysqli_query($conn,$VT_Insert_3);
            if($Result){
                $Get_VT_Report_Id_3 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_3'";
                $Result = mysqli_query($conn,$Get_VT_Report_Id_3);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_3 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_3"] = $VT_Scan_Id_3;
            }
        }
        else {
            $VT_Insert_3 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$VT_total_3','$VT_report_link_3', CURDATE(), '$VT_report_link_3', '$user_input', '$returned_URL_3')";
            $Result = mysqli_query($conn,$VT_Insert_3);
            if($Result){
                $Get_VT_Report_Id_3 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_3'";
                $Result = mysqli_query($conn,$Get_Report_Id_3);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_3 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_3"] = $VT_Scan_Id_3;
            }
        }
    
        
        //URLScan insert
        if($urlscan_score_3 || $engines_score_3 || $community_score_3 == 0){
            $URL_Results_Insert_3 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_3', '$community_score_3','$urlscan_verdict_3','$urlscan_score_3','$engines_verdict_3','$engines_total_3','$engines_score_3','$overall_verdict_3')";
            $Result = mysqli_query($conn,$URL_Results_Insert_3);
            
            if($Result == true){
                $Get_URL_Report_Id_3 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_3);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_3 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_3 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('0','$URL_report_3',CURDATE(),'$URL_report_3','$user_input','$returned_URL_3','$URL_Report_Id_3')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_3);
                    
                    if($Result){
                            $URL_Scan_Id_3= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_3'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_3);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_3 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_3"] = $URLScan_Id_3;

                        }
                }
            }
        } else {
            $URL_Results_Insert_3 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_3', '$community_score_3','$urlscan_verdict_3','$urlscan_score_3','$engines_verdict_3','$engines_total_3','$engines_score_3','$overall_verdict_3')";
            $Result = mysqli_query($conn,$URL_Results_Insert_3);
            
            if($Result == true){
                $Get_URL_Report_Id_3 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_3);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_3 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_3 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('1','$URL_report_3',CURDATE(),'$URL_report_3','$user_input','$returned_URL_3','$URL_Report_Id_3')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_3);
                    
                    if($Result){
                            $URL_Scan_Id_3= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_3'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_3);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_3 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_3"] = $URLScan_Id_3;         
                    }
                }
            }
        }
        
            $VT_Scan_Id_3 = $_SESSION["VT_Scan_Id_3"];
            $URLScan_Id_3 = $_SESSION["URL_Scan_Id_3"];
        
        if($VT_Scan_Id_3 && $URLScan_Id_3 == true){
            $Scan_Insert_3 = "INSERT INTO Scan(VTScanId, URLScanId, URLSearched, ScanDate) VALUES ('$VT_Scan_Id_3', '$URLScan_Id_3', '$returned_URL_3', CURDATE())";
            $Result = mysqli_query($conn,$Scan_Insert_3);
            
            if($Result){
                $Scan_Select_3 = "SELECT ScanId FROM Scan WHERE VTScanId = '$VT_Scan_Id_3' && URLScanId = '$URLScan_Id_3'";
                $Result = mysqli_query($conn,$Scan_Select_3);
                $Scan_row_3 = mysqli_fetch_assoc($Result);
                $Scan_Id_3 = $Scan_row_3['ScanId'];
                
                if($Result){
                    $Tool_Scan_Insert_3 = "INSERT INTO Tool_Scan(ToolId, ScanId) VALUES ('1', '$Scan_Id_3')";
                    $Result = mysqli_query($conn,$Tool_Scan_Insert_3);
                }
            }
        }

        //~ //Run the python scripts for VirusTotal and URLScan
        $VT_Return_4 = shell_exec("python /home/anmacdon/Desktop/Scraper/VTSearch.py '$returned_URL_4'");
        $URL_Return_4 = shell_exec("python /home/anmacdon/Desktop/Scraper/URLSearch.py '$returned_URL_4'");
        
        //Turn the returned values into csv format which can be used by php
        $VT_Return_4 = str_replace(array("u'","[","]"), array(""), $VT_Return_4);
 	    $VT_str_array_4 = str_getcsv($VT_Return_4, ",");
        $URL_Return_4 = str_replace(array("u'","[","]"), array(""), $URL_Return_4);
        $URL_str_array_4 = str_getcsv($URL_Return_4, ",");
        
        
        //Trim the required values and store them in variables
        $VT_report_link_4v= trim($VT_str_array_4[0], "{permalink': ");
        $VT_positives_4 = trim($VT_str_array_4[9], "positives': ");
        $VT_total_4 = trim($VT_str_array_4[10], "total': ");
        $urlscan_verdict_4 = trim($URL_str_array_4[1], "malicious': ");
        $urlscan_score_4 = trim($URL_str_array_4[2], "score': ");
        $overall_verdict_4 = trim($URL_str_array_4[7], "malicious': ");
        $engines_score_4 = trim($URL_str_array_4[23], "score': ");
        $engines_total_4 = trim($URL_str_array_4[25], "enginesTotal': }}");
        $engines_verdict_4 = trim($URL_str_array_4[21], "malicious': ");
        $community_verdict_4 = trim($URL_str_array_4[15], "votesMalicious': ");
        $community_score_4 = trim($URL_str_array_4[16], "score': ");
        $URL_report_4 = trim($URL_str_array_4[35], "reportURL': '");
    
 //        Insert for returned_URL_4

//          VirusTotal insert
        if (VT_positives_4  == 0){
            $VT_Insert_4 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('0','$VT_total_4','$VT_report_link_4', CURDATE(), '$VT_report_link_4', '$user_input', '$returned_URL_4')";
            $Result = mysqli_query($conn,$VT_Insert_4);
            if($Result){
                $Get_VT_Report_Id_4 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_4'";
                $Result = mysqli_query($conn,$Get_VT_Report_Id_4);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_4 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_4"] = $VT_Scan_Id_4;
            }
        }
        else {
            $VT_Insert_4 = "INSERT INTO VirusTotal (VTScanResult, VTEngines, VTScanURL, ScannedDate, Slug, VTReportName, VTURLSearched) values ('1','$VT_total_4','$VT_report_link_4', CURDATE(), '$VT_report_link_4', '$user_input', '$returned_URL_4')";
            $Result = mysqli_query($conn,$VT_Insert_4);
            if($Result){
                $Get_VT_Report_Id_4 = "SELECT VTScanId FROM VirusTotal WHERE VTURLSearched = '$returned_URL_4'";
                $Result = mysqli_query($conn,$Get_Report_Id_4);
                $Row = mysqli_fetch_assoc($Result);
                $VT_Scan_Id_4 = $Row['VTScanId'];
                $_SESSION["VT_Scan_Id_4"] = $VT_Scan_Id_4;
            }
        }
    
        
        //URLScan insert
        if($urlscan_score_4 || $engines_score_4 || $community_score_4 == 0){
            $URL_Results_Insert_4 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_4', '$community_score_4','$urlscan_verdict_4','$urlscan_score_4','$engines_verdict_4','$engines_total_4','$engines_score_4','$overall_verdict_4')";
            $Result = mysqli_query($conn,$URL_Results_Insert_4);
            
            if($Result == true){
                $Get_URL_Report_Id_4 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_4);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_4 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_4 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('0','$URL_report_4',CURDATE(),'$URL_report_4','$user_input','$returned_URL_4','$URL_Report_Id_4')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_4);
                    
                    if($Result){
                            $URL_Scan_Id_4= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_4'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_4);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_4 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_4"] = $URLScan_Id_4;

                        }
                }
            }
        } else {
            $URL_Results_Insert_4 = "INSERT INTO URL_Results (ReportName, CommunityVerdict, CommunityScore, URLScanVerdict, URLScanScore, EnginesVerdict, EnginesTotal, EnginesScore, OverallVerdict) VALUES ('$user_input','$community_verdict_4', '$community_score_4','$urlscan_verdict_4','$urlscan_score_4','$engines_verdict_4','$engines_total_4','$engines_score_4','$overall_verdict_4')";
            $Result = mysqli_query($conn,$URL_Results_Insert_4);
            
            if($Result == true){
                $Get_URL_Report_Id_4 = "SELECT URLResultId FROM URL_Results WHERE ReportName = '$user_input'";
                $Result = mysqli_query($conn,$Get_URL_Report_Id_4);
                $Row = mysqli_fetch_assoc($Result);
                $URL_Report_Id_4 = $Row['URLResultId'];
                
                if($Result == true){
                    $URL_Scan_Insert_4 = "INSERT INTO URLScan (URLScanResult, URLScanURL, ScannedDate, Slug, URLScanName, URLSearched, URLResultId) VALUES ('1','$URL_report_4',CURDATE(),'$URL_report_4','$user_input','$returned_URL_4','$URL_Report_Id_4')";
                    $Result = mysqli_query($conn,$URL_Scan_Insert_4);
                    
                    if($Result){
                            $URL_Scan_Id_4= "SELECT URLScanId FROM URLScan WHERE URLResultId = '$URL_Report_Id_4'";
                            $Result = mysqli_query($conn,$URL_Scan_Id_4);
                            $Row = mysqli_fetch_assoc($Result);
                            $URLScan_Id_4 = $Row['URLScanId'];
                            $_SESSION["URL_Scan_Id_4"] = $URLScan_Id_4;         
                    }
                }
            }
        }
        
            $VT_Scan_Id_4 = $_SESSION["VT_Scan_Id_4"];
            $URLScan_Id_4 = $_SESSION["URL_Scan_Id_4"];
        
        if($VT_Scan_Id_4 && $URLScan_Id_4 == true){
            $Scan_Insert_4 = "INSERT INTO Scan(VTScanId, URLScanId, URLSearched, ScanDate) VALUES ('$VT_Scan_Id_4', '$URLScan_Id_4', '$returned_URL_4', CURDATE())";
            $Result = mysqli_query($conn,$Scan_Insert_4);
            
            if($Result){
                $Scan_Select_4 = "SELECT ScanId FROM Scan WHERE VTScanId = '$VT_Scan_Id_4' && URLScanId = '$URLScan_Id_4'";
                $Result = mysqli_query($conn,$Scan_Select_4);
                $Scan_row_4 = mysqli_fetch_assoc($Result);
                $Scan_Id_4 = $Scan_row_4['ScanId'];
                
                if($Result){
                    $Tool_Scan_Insert_4 = "INSERT INTO Tool_Scan(ToolId, ScanId) VALUES ('1', '$Scan_Id_4')";
                    $Result = mysqli_query($conn,$Tool_Scan_Insert_4);
                }
            }
        }
            
//            Redirect to report.php
        header('Location: report.php' );       
    }
?>
    

    
    
    <?php include('includes/footer.php'); ?>
