const api_key = "e63fb2ad752c2e17625b63265a27a32a"

let genres = fetch("https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key).then(response => response.json()).then(data =>  {
    for (let r of data.genres) {
        let button = document.createElement('button');
        button.innerHTML = r['name'];
        button.classList = 'flex flex-col';

        button.addEventListener('click', ()=> {
            getMovieGenre(r['id'])
        })
        console.log(r)
        document.querySelector('.genre_container').appendChild(button)
    }
})

let containerMovies = document.querySelector('.movie_container');

function getMovieGenre(genre){
    fetch('https://api.themoviedb.org/3/discover/movie?api_key='+api_key+'&with_genres='+genre+'&page=1')
        .then(response => response.json())
        .then(data => {
            console.log(data["results"])
            if(containerMovies.innerHTML !== null){
                containerMovies.innerHTML = '';
            }
            data['results'].forEach(movie => {
                let img = document.createElement('img')
                img.src = 'https://image.tmdb.org/t/p/w500'+movie['poster_path'];
                containerMovies.appendChild(img);
            })
        })
}


