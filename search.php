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
    <title>Dywiki's Recherche</title>

</head>
<body>

    <?php require_once "src/template/nav.php"?>

    <form class="search relative mt-10 mx-auto border-2 border-blue-700 bg-blue-500 rounded-full w-[70vw] h-[5vw]" method="get" action="/search.php">
        <input type="text" name="query" id="search-input" class="text-[3vw] text-white outline-none bg-transparent w-[55vw] h-full absolute top-0 left-10">
        <button type="submit" class="w-[10vw] h-full bg-blue-500 float-right border-0 hover:bg-blue-700 duration-300 p-1 px-5 cursor-pointer rounded-full">
            <svg class="w-full h-full fill-white" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50"><path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"/></svg>
        </button>
    </form>

    <div class="pt-4">
        <div class="flex gap-x-6 justify-center pb-4" id="page">
            <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded hover:translate-y-1 ease-in-out duration-150" id="prev">Prev</button>
            <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded hover:translate-y-1 ease-in-out duration-150" id="next">Next</button>
        </div>
        <h1 class="font-bold text-center" id="H1_genre">

        </h1>
    </div>

    <div class="movie_container flex flex-wrap gap-8 justify-center py-12">

    </div>

    <script src="JS/api_query.js"></script>
    <script src="JS/movies.js"></script>
    <script src="JS/search.js"></script>
    <script src="JS/script.js"></script>

</body>
</html>
