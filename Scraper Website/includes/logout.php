<!--
15009351 Angus MacDonald
Tutor Suzanne Irvine
31/3/2020
-->

<?php

//Destroys sessions and resets cookie
    session_start();
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
    }
    
    setcookie ("Current_user", "", time() - 3600); 
    session_destroy();

?>