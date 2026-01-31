<?php 
    // Include configuration files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // login process code
    if (isset($_POST['submit'])) {
        // declare post variables
        $user_name = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass_key = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // validate inputs
        if (empty($user_name) || empty($pass_key)) {
            $_SESSION['login'] = "All fields are required.";
        } else {
            // check if user exists
            $sql = "SELECT * FROM users WHERE user_name=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $user_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                // verify password
                if (password_verify($pass_key, $row['password'])) {
                    // set session variables
                    $_SESSION['user_id'] = $row['id'];
                    if ($row['is_admin'] == 1) {
                        // set admin session
                        $_SESSION['is_admin'] = true;
                    }
                    header("Location: " . SITE_URL . "admin/profile.php");
                    die();
                } else {
                    $_SESSION['login'] = "Incorrect password.";
                }
            } else {
                $_SESSION['login'] = "User does not exist.";
            }
        }
        // redirect back to login page on failure
        if (isset($_SESSION['login'])) {
            header("Location: " . SITE_URL . "authentication/login.php");
            die();
        }
    } else {
        // Redirect to login page if accessed directly
        header("Location: " . SITE_URL . "authentication/login.php");
        die();
    }
    