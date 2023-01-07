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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="CSS/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dywiki's Inviter</title>

</head>
<body>

    <?php require_once "src/template/nav.php"?>

    <div class="flex fixed top-[50%] left-[50%] translate-y-[-50%] translate-x-[-50%]">
        <form class="flex flex-col p-4 place-content-center" method="post">
            <h3>Inviter une personne à rejoindre l'album "<?= $_GET["name"] ?>"</h3>
            <input type="email" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="email" placeholder="Mail de la personne à inviter">
            <button type="submit" class="bg-[#F3F3F3] drop-shadow-md rounded-full p-1 mt-2">Inviter</button>
        </form>
    </div>

    <?php
    $connection = new Connection();

    if ($_POST) {
        $invite = $connection->invite($_GET["album_id"], $_POST["email"]);

        if (is_null($invite)) {
            echo "Cet utilisateur n'existe pas";
        } else {
            echo "Invitation bien envoyé !";
            // TODO: notification center
            echo '<br>' . $invite;
        }
    }
    ?>

</body>
</html>
