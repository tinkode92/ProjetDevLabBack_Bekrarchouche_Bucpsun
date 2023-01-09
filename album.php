<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
require_once 'src/ALBUM.php';
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

if (isset($_POST['submit'])) {
    $album = new Album(
        $_POST['album_name'],
        $_POST['status'],
    );

    if ($album->verify()) {

        $connection = new Connection();
        $result = $connection->InsertAlbum($album);


        if ($result) {
            echo '<h2 class="flex items-center">Album ajouté !</h2>';
        } else {
            echo '<h2 class="flex items-center">Malheuresement, nous avons constaté une erreur...</h2>';
        }
    } else {
        echo '<h2 class="flex items-center">Veuillez mettre un nom à votre album</h2>';
    }
    header("location: album.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's Album</title>
</head>
<body>
<?php require_once"src/template/nav.php"?>

<div class="flex flex-col flex-wrap">
    <div class="flex justify-center">
        <form class="flex flex-col p-4 place-content-center w-[300px]" method="post">
            <input type="text" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md focus:bg-gray-900 transition-all focus:text-[#fefae0]" name="album_name" placeholder="Nom de l'album">
            <div class="status flex justify-around py-1" id="status">

                <div class="flex gap-x-2">
                    <label for="public" class="text-[#fefae0]">Public</label>
                    <input type="radio" name="status" value="0" id="public" checked>
                </div>

                <div class="flex gap-x-2">
                    <label for="private" class="text-[#fefae0]">Privée</label>
                    <input type="radio" name="status" value="1" id="private">
                </div>

            </div>
            <button name="submit" type="submit" class="bg-[#F3F3F3] drop-shadow-md rounded-full p-1 mt-2 transition-all hover:bg-gray-900 hover:text-[#fefae0]">Créer l'album</button>
        </form>
    </div>

    <?php

    ?>
    <div class="flex flex-wrap gap-8 justify-center py-12 2xl:px-[130px] px-8">
        <?php $connection = New Connection();
        $album = $connection->findAlbum($_SESSION["user_id"]);

        foreach ($album as $alb) {
        if ($alb['shared'] === 1) {
            $alb['status'] = "Partagé";
        } else if ($alb['status'] === 0) {
            $alb['status'] = "Public";
        } else {
            $alb['status'] = "Privée";
        }
        ?>
            <div class="flex justify-center py-4 px-2 bg-[#003049] w-[200px] rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center gap-2 hover:scale-105 transition-all">
                <p class="flex items-center text-center">Nom: <?= $alb['name']?></p>
                <p class="flex items-center text-center">Status: <?= $alb['status']?></p>
                <a class="absolute h-full w-full" href="single_album.php?&name=<?= $alb['name']?>&id=<?= $alb['id']?>&album_user_id=<?= $alb['user_id']?>"></a>
                <?php if ($alb['shared'] === 1): ?>
                <a class="z-10 py-1 text-red bg-red-300 text-white text-center rounded-t-lg rounded-b-lg w-full" href="leaveAlbum.php?id=<?= $alb['id'] ?>">Quitter</a>
                <a class="z-10 py-1 text-red bg-blue-300 text-white text-center rounded-t-lg rounded-b-lg p-2 w-full invisible" disabled href="invite.php?album_id=<?= $alb['id'] ?>&name=<?= $alb['name']?>">Ajouter quelqu'un</a>
                <?php else: ?>
                <a class="z-10 py-1 text-red bg-red-300 text-white text-center rounded-t-lg rounded-b-lg w-full" href="deleteAlbum.php?id=<?= $alb['id'] ?>">Supprimer</a>
                <a class="z-10 py-1 text-red bg-blue-300 text-white text-center rounded-t-lg rounded-b-lg p-2 w-full" href="invite.php?album_id=<?= $alb['id'] ?>&name=<?= $alb['name']?>">Ajouter quelqu'un</a>
                <?php endif ?>
            </div>
        <?php } ?>
    </div>
</div>




<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/search.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
