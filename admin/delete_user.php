<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        // redirect to login page
        $_SESSION['login'] = "Please login to access Panel.";
        header('location: ' . SITE_URL . 'authentication/login.php');
        exit();
    }
    // get id from url
    if (isset($_GET['id'])) {
        $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select user
        $select_user = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
        mysqli_stmt_bind_param($select_user, "i", $user_id);
        mysqli_stmt_execute($select_user);
        $result = mysqli_stmt_get_result($select_user);
        $user = mysqli_fetch_assoc($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>./css/style.css">
</head>
<body>
    <div class="logout">
        <h1>Delete??</h1>
        <div class="links_log">
            <a href="<?= SITE_URL ?>admin/delete_user_logic.php?id=<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">Yes</a>
            <a href="<?= SITE_URL ?>admin/settings.php">No</a>
        </div>
    </div>
</body>
</html>