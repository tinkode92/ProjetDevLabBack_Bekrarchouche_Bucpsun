<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
require_once 'src/ALBUM.php';

$connection = new Connection();

if (isset($_POST["like"])) {
    $connection->AlbumLiked($_SESSION["user_id"], $_POST["album_id"]);
    header("Location: single_user.php?id=" . $_GET['id'] . "&name=" . $_GET["name"]);
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
    <title>Dywiki's <?php echo $_GET['name']?></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>

<?php
$connection = new Connection();
$user_profile = $connection->getUser($_GET['id']);

foreach ($user_profile as $usr) {

    ?>
    <div class="flex justify-center mt-16">
        <div class="flex justify-center flex-col py-5 px-6">
            <div class="flex justify-center">
                <img src="<?php echo $usr['img_profile']?>" alt="image-profile" class= "w-[125px] h-[125px] object-cover rounded-full drop-shadow-xl border-2 border-rose-50">
            </div>
            <div class="flex flex-col my-8">
                <h1 class="text-center font-semibold text-xl"><?php echo $usr['first_name']?> <?php echo $usr['last_name']?></h1>
                <p class="text-center font-semibold text-xl"><?php echo $usr['email']?></p>
            </div>
        </div>
    </div>
<?php }

?>

<div class="flex justify-center">
    <div class="flex flex-col justify-center gap-y-4 mx-6 w-[450px] empty">
        <?php $connection = New Connection();
        $album = $connection->findAlbum($_GET["id"]);

        foreach ($album as $alb) {
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
                    <input type="submit" value="+" class="text-[#fefae0] text-2xl cursor-pointer hover:translate-x-2 transition-all rounded-full bg-[#003049] my-2 px-1" name="like">
                </form>
            <?php }
            else if ($alb['status'] === "Privée" && $alb['user_id'] === $_SESSION["user_id"]) {
                ?>
                <form class="flex gap-x-2" method="post">
                    <div class="flex justify-center w-full py-4 px-2 bg-[#003049] rounded-t-lg rounded-b-lg drop-shadow-lg flex flex-col align-center hover:scale-105 transition-all hover:drop-shadow-[0_0_3px_#fefae0]">
                        <p class="flex items-center justify-center font-semibold"><?php echo $alb['name']?></p>
                        <p class="flex items-center justify-center">Album <?php echo $alb['status']?></p>
                        <a class="absolute h-full w-full" href="single_album.php?&name=<?php echo $alb['name']?>&id=<?php echo $alb['id']?>&album_user_id=<?php echo $alb['user_id']?>"></a>
                    </div>
                    <input type="hidden" name="album_id" value="<?php echo $alb['id'] ?>">
                    <input type="submit" value="+" class="text-[#fefae0] text-2xl cursor-pointer hover:translate-x-2 transition-all rounded-full bg-[#003049] my-2 px-1" name="like">
                </form>
            <?php }
        }

        ?>
    </div>
</div>

<h2 class="flex justify-center font-semibold text-xl mt-4 text-[#fefae0]">Les albums likés</h2>
<div class="flex justify-center py-6">
    <div class="flex flex-col justify-center gap-y-4 mx-6 w-[450px] no_like">
        <?php $connection = New Connection();
        $album_liked = $connection->findAlbumLiked($_GET["id"]);

        foreach ($album_liked as $alb) {
            $album = $connection->findAlbum($alb['id']);
            if ($alb['status'] === 0) {
                $alb['status'] = "Public";
            } else {
                $alb['status'] = "Privée";
            }
            if ($alb['status'] === "Public") {
                ?>
                <div class="flex justify-center py-4 px-2 bg-[#003049] rounded-t-lg rounded-b-lg drop-shadow-lg flex flex-col align-center hover:scale-105 transition-all hover:drop-shadow-[0_0_3px_#fefae0]">
                    <p class="flex items-center justify-center font-semibold"><?php echo $alb['name']?></p>
                    <p class="flex items-center justify-center">Album <?php echo $alb['status']?></p>
                    <a class="absolute h-full w-full" href="single_album.php?&name=<?php echo $alb['name']?>&id=<?php echo $alb['id']?>&album_user_id=<?php echo $alb['user_id']?>"></a>
                </div>
            <?php }
        }

        ?>
    </div>
</div>

<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
<script type="text/javascript">
    let empty = document.querySelector(".empty")

    if (empty.children.length <= 0) {
        let message = document.createElement("p")
        message.innerHTML = "Pas d'album créer pour l'instant"
        message.classList = "flex justify-center font-semibold text-lg"
        empty.appendChild(message)
    }


</script>
</body>
</html>
