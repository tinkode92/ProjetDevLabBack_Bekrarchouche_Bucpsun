<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's Categories</title>

</head>
<body>

    <?php require_once "src/template/nav.php"?>

    <div class="genre_container flex gap-2 flex-wrap justify-center py-2 px-20">

    </div>

    <div class="pt-4">
        <div class="flex gap-x-6 justify-center pb-4" id="page">
            <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded hover:translate-y-1 ease-in-out duration-150" id="prev">Prev</button>
            <p class="font-medium flex items-center text-sm" id="before">0</p>
            <p class="font-bold flex items-center text-xl" id="current">1</p>
            <p class="font-medium flex items-center text-sm" id="after">2</p>
            <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded hover:translate-y-1 ease-in-out duration-150" id="next">Next</button>
        </div>
        <h1 class="font-bold text-center" id="H1_genre">

        </h1>
    </div>

    <div class="movie_container flex flex-wrap gap-8 justify-center py-12 2xl:px-[130px] px-8">

    </div>

    <script src="JS/api_query.js"></script>
    <script src="JS/movies.js"></script>
    <script src="JS/genres.js"></script>
    <script src="JS/script.js"></script>
</body>
</html>
