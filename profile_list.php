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
<h1 class="flex justify-center font-semibold text-xl mt-4">Page des profils inscrit</h1>
<div class="flex flex-wrap justify-center gap-6 px-2 mt-4">
    <?php $connection = New Connection();
    $user = $connection->findUser();

    foreach ($user as $usr) {

        ?>
        <div class="flex justify-center py-4">
            <div class="flex gap-x-6  w-[300px] bg-[#003049] py-3 px-6 rounded-xl shadow-lg hover:scale-105 transition-all hover:drop-shadow-[0_2px_5px_#fefae0]">
                <img class="h-[110px] w-[110px] object-cover rounded-full border-2" src="<?php echo $usr['img_profile']?>" alt="">
                <div class="flex flex-col justify-center px-1 gap-y-2">
                    <p class="flex items-center font-normal"><?php echo $usr['first_name']?> <?php echo $usr['last_name']?></p>
                    <a class="text-[#fefae0] font-semibold" href="single_user.php?id=<?php echo $usr['id']?>&name=<?php echo $usr['first_name']?>">Voir</a>
                </div>
            </div>
        </div>

    <?php }

    ?>
</div>



<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
