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
    <title>Dywiki's User</title>
</head>
<body>
<?php require_once "src/template/nav.php"?>
<h1 class="flex justify-center font-semibold text-xl">Page des profils inscrit</h1>

<?php $connection = New Connection();
$album = $connection->findUser();

foreach ($album as $alb) {

    ?>
    <div class="flex justify-center py-4">
        <div class="flex gap-x-6 bg-white py-3 px-6 rounded-xl shadow-lg hover:scale-105 transition-all hover:shadow-xl">
            <img class="h-[125px] w-[125px] object-cover rounded-full border-2" src="<?php echo $alb['img_profile']?>" alt="">
            <div class="flex flex-col justify-center">
                <p class="flex items-center font-semibold"><?php echo $alb['first_name']?> <?php echo $alb['last_name']?></p>
                <a href="">Voir</a>
            </div>
        </div>
    </div>

<?php }

?>


<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
