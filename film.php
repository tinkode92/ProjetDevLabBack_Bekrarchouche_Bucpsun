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
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_GET['name']?></title>
</head>
<body>
<?php require_once "src/template/nav.php"?>


<div class="movie_container flex flex-wrap gap-8 justify-center py-12">
    <div class="info_container justify-center w-full flex flex-col gap-y-2">
        <div class="title">

        </div>
        <div class="genre flex gap-x-2">

        </div>
        <div class="tagline">

        </div>
        <div class="synopsis flex flex-col justify-center">
            <p class="font-bold">Synopsis</p>

        </div>
        <div class="dollar flex gap-x-6">
            <div class="budget">
                <p class="font-semibold">Budget</p>
            </div>
            <div class="recette">
                <p class="font-semibold">Recette</p>
            </div>
        </div>
        <div class="note">

        </div>
    </div>
</div>



<script src="JS/api_query.js"></script>
<script src="JS/script.js"></script>
<script type="text/javascript">

    const containerMovies = document.querySelector('.movie_container');
    let info = document.querySelector('.info_container')
    let title_container = document.querySelector('.title')
    let synop_container = document.querySelector('.synopsis')
    let dollar_container = document.querySelector('.dollar')
    let budget_container = document.querySelector('.budget')
    let recette_container = document.querySelector('.recette')
    let tagline = document.querySelector('.tagline')
    let note = document.querySelector('.note')

    fetch('https://api.themoviedb.org/3/movie/' + <?php echo $_GET['id'] ?> + '?api_key='+api_key+'&language=fr-FR')
        .then(response => response.json())
        .then(data => {
            console.log(data)

            if(containerMovies.innerHTML !== null){
                containerMovies.innerHTML = '';
            }

            let card = document.createElement('div')
            containerMovies.appendChild(card)
            card.classList = 'w-[1200px] rounded-t-lg rounded-b-lg drop-shadow-xl flex align-center flex-row-reverse justify-end mx-3 gap-x-8'
            card.appendChild(info)
            card.id = "card"

            let img = document.createElement('img')
            img.classList = 'w-[300px] h-full object-cover rounded-l-lg rounded-r-lg';
            img.src = 'https://image.tmdb.org/t/p/w500'+ data['poster_path'];
            if (data['poster_path'] === null) {
                img.src = "src/assets/img/not_found.png"
            }
            card.appendChild(img);

            let title = document.createElement('p');
            title.innerHTML = data['title'];
            title.classList = "py-1 w-full font-bold text-xl"
            title_container.appendChild(title);

            let genre_container = document.querySelector(".genre")

            data['genres'].forEach(element => {
                let genre = document.createElement('p')
                genre.innerHTML = element['name']
                genre.classList = "py-1"
                genre_container.appendChild(genre)
            })

            let date = document.createElement('p')

            date.innerHTML = '- ' + data['release_date'] + " -"  ;
            date.classList = "py-1"
            genre_container.appendChild(date);

            let time = document.createElement('p')
            time.innerHTML = Math.floor(data["runtime"]/60) + "h" + data["runtime"]%60 + 'min'
            time.classList = "py-1"
            genre_container.appendChild(time)

            let synopsis = document.createElement('p')
            synopsis.innerHTML = data["overview"]
            synopsis.classList = "py-1"
            synop_container.appendChild(synopsis)

            let budget = document.createElement('p')
            budget.innerHTML = '$'+data["budget"]
            budget.classList = "py-1"
            budget_container.appendChild(budget)

            let recette = document.createElement('p')
            recette.innerHTML = '$'+data["revenue"]
            recette.classList = "py-1"
            recette_container.appendChild(recette)

            if(data["vote_average"]) {
                note.innerHTML = "Recommandé à "+ Math.floor(data["vote_average"]*10) + "%"
                note.classList = "py-1 font-semibold"
                console.log(data["vote_average"])
            }

            if(data["overview"] === "") {
                synopsis.innerHTML = "Pas de syspnosis trouvé"
            }

            if(data["revenue"] === 0){
                recette.innerHTML = "Pas d'information"
            }
            if(data["budget"] === 0) {
                budget.innerHTML = "Pas d'information"
            }

            if(data["tagline"]) {
                tagline.innerHTML = data["tagline"]
                tagline.classList = "py-1 text-gray-800 italic"
                tagline.appendChild(tagline)
            }


        })

</script>
</body>
</html>