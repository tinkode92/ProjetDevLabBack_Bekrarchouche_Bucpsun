<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
require_once 'src/ALBUM.php';
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$connection = new Connection();
$imgProfile = $connection->getImg($_SESSION["user_id"]);
if ($imgProfile !== null) {
    $_SESSION['img'] = $imgProfile;
}
if ($_POST) {
    $userId = $_SESSION["user_id"];
    $newImage = $_FILES["img"];

    $connection = new Connection();
    $result = $connection->changeImg($userId, $newImage);

    if ($result) {
        echo '<p class="font-semibold absolute bottom-[80%] right-[28%]">L\'image de profil a été mise à jour avec succès !</p>';
    } else {
        echo '<p class="font-semibold absolute bottom-[80%] right-[28%]">Une erreur s\'est produite lors de la mise à jour de l\'image de profil.</p>';
    }
    header("Refresh: 1");
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
                <img src="<?php echo $_SESSION['img']?>" alt="image-profile" class= "w-[100px] h-[100px] object-cover rounded-full drop-shadow-xl border-2 border-rose-50">
            </div>
            <form method="post" class="absolute left-1/2 text-center cursor-pointer" enctype="multipart/form-data">
                <div class="absolute bottom-0 ml-[15px] mt-[5px] bg-white w-[32px] h-[32px] text-center rounded-full text-center leading-8 border">
                    <input class="scale-[1] opacity-0 absolute" type="file" id="update_img" name="img" accept="png/jpeg/jpg">
                    <i class="fa fa-camera cursor-pointer"></i>
                </div>
                <input class="absolute" type="submit" value="Changer" name="img">
            </form>
        </div>
        <div class="flex flex-col my-8">
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
