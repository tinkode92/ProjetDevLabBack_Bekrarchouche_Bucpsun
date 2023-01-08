<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$connection = new Connection();
$imgProfile = $connection->getImg($_SESSION["user_id"]);

?>

<!DOCTYPE HTML>
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

    <!--NAVBAR ELEMENT IN TEMPLATE FOLDER-->
    <?php require_once "src/template/nav.php"?>

    <script src="JS/script.js"></script>

</body>
</html>
