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


<?php $connection = New Connection();
$album = $connection->findUser();

foreach ($album as $alb) {
    var_dump($alb);
    ?>
    <div class="flex justify-center py-4">
        <div>
            <p class="font-semibold"><?php echo $alb['first_name']?> <?php echo $alb['last_name']?></p>
            <a class="" href=""></a>
        </div>
    </div>

<?php }

?>


<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
