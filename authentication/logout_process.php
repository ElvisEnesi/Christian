<?php
    // Include configuration files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // logout process code
    // Destroy all session data
    session_unset();
    session_destroy();
    // Redirect to login page
    header("Location: " . SITE_URL . "accessible/index.php");
    die();