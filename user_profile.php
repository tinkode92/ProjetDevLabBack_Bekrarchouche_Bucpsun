<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
require_once 'src/ALBUM.php';

// on vérifie que la session possède un user_id, si ce n'est pas le cas, alors on le renvoie sur la page login
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

// on utilise la fonction getImg qui récupère le lien de l'image depuis la bdd afin de directement mettre à jour la photo
$connection = new Connection();
$imgProfile = $connection->getImg($_SESSION["user_id"]);
if ($imgProfile !== null) {
    $_SESSION['img'] = $imgProfile;
}
// on utilise la fonction pour changer de photo de profil
if (isset($_POST["change_img"])) {
    $userId = $_SESSION["user_id"];
    $newImage = $_FILES["change_img"];

    $connection = new Connection();
    $result = $connection->changeImg($userId, $newImage);

    header("Location: user_profile.php");
}
// on utilise la fonction pour dislike un album
if (isset($_POST['dislike'])) {
    $connection = new Connection();
    $connection->AlbumDisliked($_SESSION['user_id'], $_POST['album_id']);

    header("Location: user_profile.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's <?php echo $_SESSION["user_name"]?></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>

<div class="flex justify-center mt-16">
    <div class="flex justify-center flex-col py-5 px-6">
        <div class="relative">
            <div class="flex justify-center">
                <img src="<?php echo $_SESSION['img']?>" alt="image-profile" class= "w-[125px] h-[125px] object-cover rounded-full drop-shadow-xl border-2 border-rose-50">
            </div>
            <form method="post" class="absolute left-1/2 text-center cursor-pointer" enctype="multipart/form-data">
                <div class="absolute bottom-0 ml-[15px] mt-[5px] bg-white w-[32px] h-[32px] text-center rounded-full text-center leading-8 border">
                    <input class="scale-[1] opacity-0 absolute" type="file" id="update_img" name="change_img" accept="png/jpeg/jpg">
                    <i class="fa fa-camera cursor-pointer"></i>
                </div>
                <input class="absolute text-[#fefae0] py-1 px-2 my-1 bg-[#003049] rounded-lg" type="submit" value="Changer" name="change_img">
            </form>
        </div>
        <div class="flex flex-col my-10">
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
            <div class="flex justify-center w-full py-4 px-2 bg-[#003049] rounded-t-lg rounded-b-lg drop-shadow-lg flex flex-col align-center hover:scale-105 transition-all hover:drop-shadow-[0_0_3px_#fefae0]">
                <p class="flex items-center justify-center font-semibold"><?php echo $alb['name']?></p>
                <p class="flex items-center justify-center">Album <?php echo $alb['status']?></p>
                <a class="absolute h-full w-full" href="single_album.php?&name=<?php echo $alb['name']?>&id=<?php echo $alb['id']?>&album_user_id=<?php echo $alb['user_id']?>"></a>
            </div>
        <?php }

        ?>
    </div>
</div>

<h2 class="flex justify-center font-semibold text-xl mt-4 text-[#fefae0]">Les albums likés</h2>
<div class="flex justify-center py-6">
    <div class="flex flex-col justify-center gap-y-4 mx-6 w-[450px] no_like">
        <?php $connection = New Connection();
        $album_liked = $connection->findAlbumLiked($_SESSION["user_id"]);

        foreach ($album_liked as $alb) {
            $album = $connection->findAlbum($alb['id']);
            if ($alb['status'] === 0) {
                $alb['status'] = "Public";
            } else {
                $alb['status'] = "Privée";
            }
            if ($alb['status'] === "Public") {
                ?>
                <form class="flex gap-x-2" method="post">
                    <div class="flex justify-center w-full py-4 px-2 bg-[#003049] rounded-t-lg rounded-b-lg drop-shadow-lg flex flex-col align-center hover:scale-105 transition-all hover:drop-shadow-[0_0_3px_#fefae0]">
                        <p class="flex items-center justify-center font-semibold"><?php echo $alb['name']?></p>
                        <p class="flex items-center justify-center">Album <?php echo $alb['status']?></p>
                        <a class="absolute h-full w-full" href="single_album.php?&name=<?php echo $alb['name']?>&id=<?php echo $alb['id']?>&album_user_id=<?php echo $alb['user_id']?>"></a>
                    </div>
                    <input type="hidden" name="album_id" value="<?php echo $alb['id'] ?>">
                    <input type="submit" value="-" class="text-[#fefae0] text-2xl cursor-pointer hover:translate-x-2 transition-all rounded-full bg-[#003049] my-2 px-1" name="dislike">
                </form>
            <?php }
        }


        ?>
    </div>
</div>


<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
