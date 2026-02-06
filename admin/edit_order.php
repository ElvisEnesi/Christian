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
        $order_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select category
        $select_order = mysqli_prepare($conn, "SELECT * FROM orders WHERE id=?");
        mysqli_stmt_bind_param($select_order, "i", $order_id);
        mysqli_stmt_execute($select_order);
        $result = mysqli_stmt_get_result($select_order);
        $order = mysqli_fetch_assoc($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>css/style.css">
</head>
<body>
    <?php
        if (isset($_SESSION['update_status'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['update_status'];
            echo "</div>";
        }
        unset($_SESSION['update_status']);
    ?>
    <h1>Edit Status</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/update_status.php" method="post" class="checkout_form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
            <select name="status">
                <option value="pending">Pending</option>
                <option value="disbursed">Disbursed</option>
            </select>
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>