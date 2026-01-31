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
        if (isset($_SESSION['register_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['register_success'];
            echo "</div>";
        }
        unset($_SESSION['register_success']);
    ?>
    <?php
        if (isset($_SESSION['login'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['login'];
            echo "</div>";
        }
        unset($_SESSION['login']);
    ?>
    <section class="login">
        <h1>Login</h1>
        <form class="form_container" action="<?= SITE_URL ?>authentication/login_process.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="submit">Login</button>
        </form>
        <div class="note">
            Don't have an account? <a href="<?= SITE_URL ?>authentication/register.php">Register here</a>
        </div>
    </section>
</body>
</html>