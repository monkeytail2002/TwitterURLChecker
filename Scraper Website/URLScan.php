<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
08/4/2020
-->

<!--Required modules-->
<?php require_once('config.php'); ?>
<?php require_once( ROOT_PATH . '/includes/public_functions.php'); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php'); ?>

<!--Checks if user session is valid-->
<?php
if($_SESSION['Valid']){
	} else {
	header("Location:index.php");
} ?>



<!-- Calls function -->
<?php $posts = getURLScanPosts(); ?>


	<title>URLScan.io Reports | Security Suite</title>
</head>
<body>

	<div class="container">

		<div class="content">
            
            <hr>
            
            <!--Displays the same as the index.  Filtered topics as a button, titles and dates for posts-->
            <?php foreach ($posts as $post): ?>
            <div class="post" style="margin-left: 0px;">
                <img src="<?php echo BASE_URL . '/static/images/report.jpg'; ?>" class="post_image" alt="">
                <a href="single_report.php?post-slug=<?php echo $post['URLScanURL']; ?>">
                    <div class="post_info">
                        <h3><?php echo $post['URLScanName']; ?></h3>
                        <div class="info">
                            <span><?php echo date("F j, Y ", strtotime($post["ScannedDate"])); ?></span>
                            <span class="read_more">Read more...</span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach ?>
            
		</div>
        
        
        
        
        <script>
    
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
		
		<!-- Include Footer page -->
<?php include('includes/footer.php') ?>
		
