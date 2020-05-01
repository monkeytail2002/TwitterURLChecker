<!--Required modules-->
<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php include('includes/head_section.php'); ?>

<!--Calls functions-->
<?php 
		if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
?>



<title> Report | Security Tool</title>
</head>
<body>
<div class="container">
	
	
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>

	
	<?php $seshid = $_SESSION['UserId']; ?>
	
<!--	Displays post information.-->
	<div class="content" >
			<div class="post-wrapper">
						<?php 
                        if ($post['VTScanId']){
                        $vpid = $post['VTScanId'];
			$ReportURL = $post['VTScanURL'];
                        $Date = $post['ScannedDate'];
                        $URLSearched = $post['VTURLSearched'];
                        $scan_result = $post['VTScanResult'];
                        $VTReportName = $post['VTReportName'];
			$engines = $post['VTEngines'];
			
                    ?>        
                    <div class="full-post-div">
                    <img src="<?php echo BASE_URL . '/static/images/report.jpg' ?>">
                    <h2 class="post-title">Report For <?php echo $VTReportName;?></h2>
                    <br>
                    <h2 class="post-title">URL Scanned: <?php echo $URLSearched;?></h2>
                     <div class="post-body-div">
                            <?php
			    
						if ($ScanResult == 1){
                            ?>
                            <p>This URL is marked as clean by <?php echo $scan_result; ?> out of <?php echo $engines; ?></p>
                            <br><br>
                            <p>Full report can be found here: <?php echo '<a href='.$ReportURL.'>'.'VirusTotal Report Page'.'</a>'; ?></p>
                            <br><br>
                            <p>This URL was scanned on <?php echo $Date; ?></p>
                            <br><br>
                            <?php                            
                        } else if ($ScanResult == 0){
                            ?>
			    <br>
                            <p>This URL is marked as clean by <?php echo $scan_result; ?> out of <?php echo $engines; ?></p>
                            <br><br>
                            <p>Full report can be found here: <?php  echo '<a href='.$ReportURL.'>'.'VirusTotal Report Page'.'</a>'; ?></p>
                            <br><br>
                            <p>This URL was scanned on <?php echo $Date; ?></p>
                            <br><br>
                        <?php
                        } 
                        
                    } 
                
                else if ($post['URLScanId']){
                        $upid = $post['URLScanId'];
			$ReportURL = $post['URLScanURL'];
                        $Date = $post['ScannedDate'];
                        $URLSearched = $post['URLSearched'];
                        $URLReportName = $post['URLScanName'];
			$report_id = $post['URLResultId'];
			$scan_result = $post['URLScanResult'];
		
                        ?>
                
                <div class="full-post-div">
                    <img src="<?php echo BASE_URL . '/static/images/URLScanLogo.jfif'; ?>">
                    <h2 class="post-title">Report For <?php echo $URLReportName;?></h2>
                    <br>
                    <h2 class="post-title">URL Scanned: <?php echo $URLSearched;?></h2>
                        <div class="post-body-div">
                            <?php
						if ($scan_result == 1){
                            ?>
                            <p>This URL is malicious</p>
                            <br><br>
                            <p>Full report can be found here: <?php echo '<a href='.$ReportURL.'>'.'URLScan Report Page'.'</a>'; ?></p>
                            <br><br>
                            <p>This URL was scanned on <?php echo $Date; ?></p>
                            <br><br>
                            <?php                            
                        } else if ($ScanResult == 0){
                            ?>
                            <p>This URL is marked as clean</p>
                            <br><br>
                            <p>Full report can be found here: <?php  echo '<a href='.$ReportURL.'>'.'URLScan Report Page'.'</a>'; ?></p>
                            <br><br>
                            <p>This URL was scanned on <?php echo $Date; ?></p>
                            <br><br>
                        <?php
                        }
                        }
                        ?>
                        
				</div>
			</div>
        </div>
                </div>
        </div>

	
        <div class="full-post-div">
            <?php
            $suspend = $_SESSION['susp'];
                         
            if ($seshid == true && $suspend == '1'){
                ?>
            <form action="update.php" method = "post">
                <textarea name="comment" class = "txtentry" placeholder="Leave a comment..." style="resize: none;" rows = "4" cols = "50"></textarea>
                <input class="btn" type="submit" value = "Comment">
            </form>
        			 	<br>	
				  					<br>
			<?php		
					
				} else if($seshid == false){
					echo 'Please '.'<a href = "index.php">'.'sign in '.'</a>'.'to leave a comment'.'<br>';
				echo '<br>';	
		
				}  else if($seshid == true && $suspend == '2'){
//		Checks if the user is suspended and removes the form
				echo "As a suspended user you are unable to post comments.  Please contact the site administrator from the contacts page if you think you have been suspended incorrectly.".'<br>'.'<br>';
			}
	
				
				
				
				
				
//				Shows the comments
                
                if($post['VTScanId']){
                    $sql = "SELECT * FROM Comments WHERE VTScanId = '$vpid' ORDER BY Posted DESC";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $comm = $row['CommentBody'];
                    $comm = stripslashes($comm);
                    $commusr = $row['UserId'];
                    $_SESSION['vpid'] = $vpid;
                    
                    if ($result == true){
//                        If there are comments in the post then run query to recover and display required information.
                        
                        $commentuser = "SELECT * FROM Users u INNER JOIN Comments c ON u.UserId = c.UserId WHERE VTScanId = '$vpid'";
                        $cresult = mysqli_query($conn, $commentuser);
                        while ($crow = mysqli_fetch_array($cresult))
                        { ?>
                <div class="full-comment-div">
                    <?php
                            $commentbody= $crow['CommentBody'];
                            $commentbody = stripslashes($commentbody);
                            $comid = $crow['CommentId'];
                            $comus = $crow['Username'];
                            $comus = stripslashes($comus);
                            $susp = $crow['Suspended'];
                            $_SESSION['suspstp'] = $susp;
                            $comtime = $crow['Posted'];
                            
                            echo '<p style="word-wrap: break-word;">'.html_entity_decode($commentbody).'</p>';
                            echo '<p style="word-wrap: break-word;">'.$comtime.'</p>';
                            echo '<br>'; ?>
                    <img src="<?php echo BASE_URL . '/static/images/' . $crow['Image']; ?>" alt="" class="profile_pic" height ="30", width = "30" align="left">
                    <?php
                            echo '<p style="word-wrap: break-word;">'.$comus.'</p>';
                            echo '<br>';
//                            Checks if user is suspended and adds a visible marker next to their name.
                            if($susp == '2'){
                                echo '<font color="#ff0000">'."suspended user".'</font>';
                            }
//                            Checks if user is admin and supplies admin options
                            if($_SESSION["UserLevel"] == "2"){?>
                    <form action="update.php" method = "post">
                        <input type = "hidden" name = "delcom" value = "<?php echo $comid ?>">
                        <input class="btn" type="submit" value = "delete">
                    </form>
                    <form action="update.php" method = "post">
                        <input name = "comsus" type="hidden" value = "<?php echo $comus ?>">
                        <input class="btn" type="submit" value = "suspend">
                    </form>
                    <?php
                                                             } ?>
                </div>
                        <?php
					}
					
				}
				
                }
				else if($post['URLScanId']){
                    $sql = "SELECT * FROM Comments WHERE URLScanId = '$upid' ORDER BY Posted DESC";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $comm = $row['CommentBody'];
                    $comm = stripslashes($comm);
                    $commusr = $row['UserId'];
                    $_SESSION['upid'] = $upid;
                    
                    if ($result == true){
//                        If there are comments in the post then run query to recover and display required information.
                        
                        $commentuser = "SELECT * FROM Users u INNER JOIN Comments c ON u.UserId = c.UserId WHERE URLScanId = '$upid'";
                        $cresult = mysqli_query($conn, $commentuser);
                        while ($crow = mysqli_fetch_array($cresult))
                        { ?>
                <div class="full-comment-div">
                    <?php
                            $commentbody= $crow['CommentBody'];
                            $commentbody = stripslashes($commentbody);

                            $comid = $crow['CommentId'];
                            $comus = $crow['Username'];
                            $comus = stripslashes($comus);
                            $susp = $crow['Suspended'];
                            $_SESSION['suspstp'] = $susp;
                            $comtime = $crow['Posted']; 

                            echo '<p style="word-wrap: break-word;">'.html_entity_decode($commentbody).'</p>';
                            echo '<p style="word-wrap: break-word;">'.$comtime.'</p>';
                            echo '<br>'; ?>
                    <img src="<?php echo BASE_URL . '/static/images/' . $crow['Image']; ?>" alt="" class="profile_pic" height ="30", width = "30" align="left">
                    <?php
                            echo '<p style="word-wrap: break-word;">'.$comus.'</p>';
                            echo '<br>';
//                            Checks if user is suspended and adds a visible marker next to their name.
                            if($susp == '2'){
                                echo '<font color="#ff0000">'."suspended user".'</font>';
                            }
//                            Checks if user is admin and supplies admin options
                            if($_SESSION["UserLevel"] == "2"){?>
                    <form action="update.php" method = "post">
                        <input type = "hidden" name = "delcom" value = "<?php echo $comid ?>">
                        <input class="btn" type="submit" value = "delete">
                    </form>
                    <form action="update.php" method = "post">
                        <input name = "comsus" type="hidden" value = "<?php echo $comus ?>">
                        <input class="btn" type="submit" value = "suspend">
                    </form>
                    <?php
                                                             } ?>
                </div>
                        <?php
					}
					
				}
				
                }
			
			
			?>
                    
                            
                
                            
                </div>

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
	
<!--	Footer-->
<?php include( ROOT_PATH . '/includes/footer.php'); ?>
