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


<div class="genre_container">

</div>

<div class="movie_container">

</div>


<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
</body>
</html>