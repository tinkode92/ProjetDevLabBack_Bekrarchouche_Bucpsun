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
<body class="h-[100vh]">

    <!--NAVBAR ELEMENT IN TEMPLATE FOLDER-->
    <?php require_once "src/template/nav.php"?>

    <img class="absolute floating w-[100px] top-[10%] left-[15%]" src="src/assets/img/popcorn.png">
    <img class="absolute floating w-[150px] top-[55%] left-[10%]" src="src/assets/img/glasses.png">
    <img class="absolute floating w-[150px] top-[15%] left-[80%]" src="src/assets/img/clap.png">
    <img class="absolute floating w-[150px] top-[65%] left-[30%]" src="src/assets/img/tickets.png">
    <img class="absolute floating w-[100px] top-[60%] left-[60%]" src="src/assets/img/cup.png">
    <img class="absolute floating w-[100px] top-[54%] left-[85%]" src="src/assets/img/camera.png">

    <div class="wrapper my-[150px] flex justify-items-center items-center row w-full h-full flex-col gap-5 z-10">
        <h1 class="text-4xl text-[#fefae0]">Bienvenu <?php echo $_SESSION["user_name"]?> sur Dywiki's !</h1>
        <h3 class="text-2xl text-[#fefae0]">Renseigne toi sur l'actualitées des films et séries !</h3>
        <a class="text-xl hover:bg-blue-400 text-white font-bold py-3 px-5 border-2 border-blue-700 hover:border-blue-500 rounded hover:translate-y-1 ease-in-out duration-150" href="categorie.php">C'est parti !</a>
    </div>

    <script src="JS/script.js"></script>

</body>
</html>
