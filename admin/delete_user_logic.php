<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // get id from url
    if (isset($_GET['id'])) {
        $users_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select users
        $select_users = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
        mysqli_stmt_bind_param($select_users, "i", $users_id);
        mysqli_stmt_execute($select_users);
        $result = mysqli_stmt_get_result($select_users);
        $users = mysqli_fetch_assoc($result);
    } else {
        header("location: " . SITE_URL . "admin/settings.php");
        exit;
    }
    $previous_image = $users['picture'];
    $previous_image_path = "../images/users/" . $previous_image;
    if ($previous_image_path) {
        // unlink image from folder
        unlink($previous_image_path);
    }
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $users['id']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) >= 0) {
        session_unset();
        session_destroy();       
        header("location: " . SITE_URL . "accessible/index.php");
        exit;
    } else {
        $_SESSION['delete_users'] = "Delete failed!";
        header("location: " . SITE_URL . "admin/settings.php");
        exit;
    }
?>