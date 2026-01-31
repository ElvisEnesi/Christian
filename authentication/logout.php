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
    <div class="logout">
        <h1>Log out?</h1>
        <div class="links_log">
            <a href="<?= SITE_URL ?>authentication/logout_process.php">Yes</a>
            <a href="<?= SITE_URL ?>admin/profile.php">No</a>
        </div>
    </div>
</body>
</html>