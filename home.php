<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Accueil Dywiki's</title>
</head>
<body>

<div class="flex flex-col">
    <?php echo 'Hello ' .  $_SESSION['user_last_name'] . ' ' . $_SESSION['user_name'] . ' !'; ?>
    <?php echo '<a class="text-[#7BC8FF]" href="src/logout.php' . '">Déconnexion</a>'; ?>
</div>

</body>
</html>
