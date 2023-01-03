<?php
session_start();
require_once 'src/user.php';
require_once 'src/connection.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's <?php echo $_GET['name'] ?></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>

<h1 class="text-center font-semibold text-xl mt-2">Liste de l'Album: <?php echo $_GET['name'] ?> </h1>



<div class="container_album_movie flex flex-wrap gap-8 justify-center py-12 2xl:px-[130px] px-8">

</div>




<script src="JS/api_query.js"></script>
<script src="JS/movies.js"></script>
<script src="JS/search.js"></script>
<script src="JS/script.js"></script>
<?php $connection = New Connection();
$movie = $connection->findAlbumMovie($_GET['id']);

foreach ($movie as $mov) {

    ?>
    <script type="text/javascript">
        fetch('https://api.themoviedb.org/3/movie/' + <?php echo $mov['id_api'] ?> + '?api_key='+api_key+'&language=fr-FR')
            .then(response => response.json())
            .then(data => {
                console.log(data);

                let card = document.createElement('div')
                containerAlbumMovie.appendChild(card)
                card.classList = 'w-[250px] bg-white rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center'

                const img = document.createElement('img')
                img.classList = 'w-[250px] h-[350px] object-cover rounded-t-lg';
                img.src = 'https://image.tmdb.org/t/p/w500'+data['poster_path'];
                if (data['poster_path'] === null) {
                    img.src = "src/assets/img/not_found.png"
                }
                card.appendChild(img);

                const title = document.createElement('p');
                title.innerHTML = data['title'];
                title.classList = "text-center py-1"
                card.appendChild(title);

                let link = document.createElement('a');
                link.href = "film.php?" + "&id=" + data['id'] + "&name=" + data['title']
                link.classList = "h-full w-full absolute"
                card.appendChild(link)

                let deletee = document.createElement('a');
                deletee.href = "deleteMovie.php?id=" + <?php echo $mov['id']?>;
                deletee.classList = "z-10 py-1 text-red bg-red-300 text-white text-center rounded-t-lg rounded-b-lg"
                deletee.innerHTML = "Supprimer"
                card.appendChild(deletee)
            })
    </script>
<?php }

?>
</body>
</html>
