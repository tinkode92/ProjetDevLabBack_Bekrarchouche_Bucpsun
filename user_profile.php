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
    <title>Dywiki's <?php echo $_SESSION["user_name"]?></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>

<div class="flex justify-center mt-16">
    <div class="flex justify-center flex-col py-5 px-6">
        <div class="flex justify-center">
            <img src="src/assets/img/usser.png" alt="image-profile" class= "w-[100px] object-cover rounded-full drop-shadow-xl">
        </div>

        <div class="flex flex-col my-4">
            <h1 class="text-center font-semibold text-xl"><?php echo $_SESSION["user_name"]?> <?php echo $_SESSION["user_last_name"]?></h1>
            <p class="text-center font-semibold text-xl"><?php echo $_SESSION["user_email"]?></p>
        </div>
    </div>
</div>
<div class="flex justify-center">
    <div class="flex flex-col justify-center gap-y-4 mx-6 w-[450px]">
        <?php $connection = New Connection();
        $album = $connection->findAlbum($_SESSION["user_id"]);

        foreach ($album as $alb) {
            if ($alb['status'] === 0) {
                $alb['status'] = "Public";
            } else {
                $alb['status'] = "Privée";
            }
            ?>
            <div class="flex justify-center py-4 px-2 bg-white rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center hover:scale-105 transition-all">
                <p class="flex items-center justify-center font-semibold"><?php echo $alb['name']?></p>
                <p class="flex items-center justify-center">Album <?php echo $alb['status']?></p>
                <a class="absolute h-full w-full" href="single_album.php?&name=<?php echo $alb['name']?>&id=<?php echo $alb['id']?>"></a>
            </div>
        <?php }

        ?>
    </div>

</div>



<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
