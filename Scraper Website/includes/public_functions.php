<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
02/4/2020
-->

<?php 


/* * * * * * * * * * * * * * *
* Returns all published results
* * * * * * * * * * * * * * */

function getVirusTotalPosts() {
	// use global $conn object in function
	global $conn;
	$vtsql = "SELECT * FROM VirusTotal";
	$result = mysqli_query($conn, $vtsql);

	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
    	foreach ($posts as $post) {
            $post['topic'] = getVTTopic($post['VTScanId']); 
            array_push($final_posts, $post);

	}
	return $final_posts;
}

function getURLScanPosts() {
	// use global $conn object in function
	global $conn;
	$urlsql = "SELECT * FROM URLScan";
	$result = mysqli_query($conn, $urlsql);

	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
    	foreach ($posts as $post) {
            $post['urltopic'] = getURLTopic($post['URLScanId']); 
            array_push($final_posts, $post);

	}
	return $final_posts;
}


/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getVTTopic($VTScanId){
	global $conn;
	$sql = "SELECT * FROM Scan WHERE VTScanId = $VTScanId LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}


function getURLTopic($VTScanId){
	global $conn;
	$sql = "SELECT * FROM Scan WHERE URLScanId = $URLScanId LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $urltopic;
}



/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;
	// Get single post slug
    $post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM VirusTotal WHERE Slug = '$post_slug'";
	$result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    
    if ($post_slug != $post['Slug']){
    $ursql = "SELECT * FROM URLScan WHERE Slug = '$post_slug'";
    $urresult = mysqli_query($conn, $ursql);
    $post = mysqli_fetch_assoc($urresult);
    return $post;
    } else if ($post_slug == $post['Slug']) {
        return $post;
    }

}

