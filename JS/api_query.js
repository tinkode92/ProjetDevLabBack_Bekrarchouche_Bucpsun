const api_key = "e63fb2ad752c2e17625b63265a27a32a"

fetch("https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key+'&language=fr-FR').then(response => response.json()).then(data =>  {
    for (let r of data.genres) {
        let button = document.createElement('button');
        button.innerHTML = r['name'];
        button.classList = 'bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded ease-in-out duration-150';

        button.addEventListener('click', ()=> {
            getMovieGenre(r['id'])
            let genre_title= document.querySelector('#H1_genre')
            genre_title.innerHTML = 'Categorie: ' + r['name']
        })

        document.querySelector('.genre_container').appendChild(button)
    }

})

let containerMovies = document.querySelector('.movie_container');



function getMovieGenre(genre){
    fetch('https://api.themoviedb.org/3/discover/movie?api_key='+api_key+'&with_genres='+genre+'&language=fr-FR')
        .then(response => response.json())
        .then(data => {
            console.log(data)
            if(containerMovies.innerHTML !== null){
                containerMovies.innerHTML = '';
            }

            data['results'].forEach(movie => {
                let card = document.createElement('div')
                containerMovies.appendChild(card)
                card.classList = 'w-[250px] bg-white rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center'
                card.id = "card"

                let img = document.createElement('img')
                img.classList = 'w-[250px] h-[350px] object-cover rounded-t-lg';
                img.src = 'https://image.tmdb.org/t/p/w500'+movie['poster_path'];
                card.appendChild(img);

                let title = document.createElement('p');
                title.innerHTML = movie['title'];
                title.classList = "text-center py-1"
                card.appendChild(title);


                let link = document.createElement('a');
                link.href = "film.php?" + "&id=" + movie['id'] + "&name=" + movie['title']
                link.classList = "h-full w-full absolute"
                card.appendChild(link)

            })

        })

}

