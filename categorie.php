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
    <title>Dywiki's Categories</title>
</head>
<body>
<?php require_once "src/template/nav.php"?>


<div class="genre_container grid gap-0.5">

</div>

<div class="movie_container flex flex-wrap gap-8 justify-center py-12">

</div>

<div class="flex gap-x-6 justify-center pb-4" id="page">
    <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" id="prev">Left</button>
    <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" id="next">Right</button>
</div>


<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
