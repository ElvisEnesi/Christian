    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
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
    <?php
        if (isset($_SESSION['register'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['register'];
            echo "</div>";
        }
        unset($_SESSION['register']);
    ?>
    <section class="login">
        <h1>Register</h1>
        <form class="form_container" action="<?= SITE_URL ?>authentication/register_process.php" method="post" enctype="multipart/form-data">
            <input type="text" name="fullname" placeholder="Full Name">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="text" name="address" placeholder="Address">
            <input type="password" name="create" placeholder="Create password">
            <input type="password" name="confirm" placeholder="Confirm password">
            <input type="file" name="avatar">
            <button type="submit" name="submit">Register</button>
        </form>
        <div class="note">
            Already have an account? <a href="<?= SITE_URL ?>authentication/login.php">Login!!</a>
        </div>
    </section>
</body>
</html>