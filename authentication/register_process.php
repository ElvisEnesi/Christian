<?php
    // include database and constant files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // register process code will go here
    if (isset($_POST['submit'])) {
        // declare post variables
        $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $user_name = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $create = filter_var($_POST['create'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm = filter_var($_POST['confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];
        // validation
        if (!$fullname || !$email || !$user_name || !$phone || !$address || !$create || !$confirm) {
            $_SESSION['register'] = "All fields are required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register'] = "Invalid email address";
        } elseif (strlen($create) < 8 || strlen($confirm) < 8) {
            $_SESSION['register'] = "Password should be at least 8 characters long";
        } elseif ($create !== $confirm) {
            $_SESSION['register'] = "Passwords do not match";
        } else {
            // process avatar 
            if ($avatar['name']) {
                $time = time(); // make each image name unique with current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/users/' . $avatar_name;
                // check file type
                $allowed_files = ['image/png', 'image/jpeg', 'image/jpg'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $type = finfo_file($finfo, $avatar_tmp_name);
                if (in_array($type, $allowed_files)) {
                    // check file size
                    if ($avatar['size'] < 2_000_000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['register'] = "File size too big. Should be less than 2MB";
                    }
                } else {
                    $_SESSION['register'] = "File should be png, jpg or jpeg";
                }
            } else {
                $_SESSION['register'] = "Please choose an avatar";
            }
        }
        // redirect back if there's any error
        if (isset($_SESSION['register'])) {
            header("Location: " . SITE_URL . "authentication/register.php");
            die();
        } else {
            // hash password
            $hashed_password = password_hash($create, PASSWORD_DEFAULT);
            // insert user into database
            $insert_user_query = "INSERT INTO users (full_name, email, user_name, phone, address, password, picture) VALUES (?,?,?,?,?,?,?)";
            $insert_user_stmt = mysqli_prepare($conn, $insert_user_query);
            mysqli_stmt_bind_param($insert_user_stmt, "sssssss", $fullname, $email, $user_name, $phone, $address, $hashed_password, $avatar_name);
            mysqli_stmt_execute($insert_user_stmt);
            // if any connection error
            if (mysqli_errno($conn)) {
                unlink($avatar_destination_path);
                $_SESSION['register'] = "Error: Failed to register";
                header("Location: " . SITE_URL . "authentication/register.php");
                die();  
            } else {
                $_SESSION['register_success'] = "Registration successful. Please login.";
                header("Location: " . SITE_URL . "authentication/login.php");
                die();
            }
        }
    } else {
        // Redirect to register page if accessed directly
        header("Location: " . SITE_URL . "authentication/register.php");
        die();
    }
    