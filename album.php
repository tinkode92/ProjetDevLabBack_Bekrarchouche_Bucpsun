<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
require_once 'src/ALBUM.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's Album></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>

<div class="flex">
    <form class="flex flex-col p-4 place-content-center" method="post">
        <input type="text" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="album_name" placeholder="Nom de l'album">
        <div class="status flex justify-around py-1" id="status">

            <div class="flex gap-x-2">
                <label for="public">Public</label>
                <input type="radio" name="status" value="0" id="public" checked>
            </div>

            <div class="flex gap-x-2">
                <label for="private">Privée</label>
                <input type="radio" name="status" value="1" id="private">
            </div>

        </div>
        <button name="submit" type="submit" class="bg-[#F3F3F3] drop-shadow-md rounded-full p-1 mt-2">Créer l'album</button>
    </form>
</div>




<?php
if ($_POST) {
    $album = new Album(
        $_POST['album_name'],
        $_POST['status'],
    );

    if ($album->verify()) {

        $connection = new Connection();
        $result = $connection->InsertAlbum($album);


        if ($result) {
            echo '<h2 class="msg">Album ajouté !</h2>';
        } else {
            echo '<h2 class="msg">Malheuresement, nous avons constaté une erreur...</h2>';
        }
    } else {
        echo '<h2 class="msg">Veuillez mettre un nom à votre album</h2>';
    }
    exit();
}
?>

<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/search.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
