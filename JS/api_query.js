const api_key = "e63fb2ad752c2e17625b63265a27a32a"

let genres = fetch("https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key).then(response => response.json()).then(data =>  {
    for (let r of data.genres) {
        let button = document.createElement('button');
        button.innerHTML = r['name'];
        button.classList = 'w-[125px] bg-gray-700 text-white p-1 rounded-full';

        button.addEventListener('click', ()=> {
            getMovieGenre(r['id'])
        })
        console.log(r)
        document.querySelector('.genre_container').appendChild(button)
    }
})

let containerMovies = document.querySelector('.movie_container');

let PaginationPrev = document.querySelector(".prev")
let PaginationNext = document.querySelector(".next")
let page_number = document.querySelector("#page")


let pagination = 1

function getMovieGenre(genre){
    fetch('https://api.themoviedb.org/3/discover/movie?api_key='+api_key+'&with_genres='+genre)
        .then(response => response.json())
        .then(data => {
            if(containerMovies.innerHTML !== null){
                containerMovies.innerHTML = '';
            }



            data['results'].forEach(movie => {
                let card = document.createElement('div')
                    containerMovies.appendChild(card)
                    card.classList = 'w-[250px] bg-gray-300 rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center'

                let img = document.createElement('img')
                    img.classList = 'w-[250px] h-[350px] object-cover rounded-t-lg';
                    img.src = 'https://image.tmdb.org/t/p/w500'+movie['poster_path'];
                    card.appendChild(img);

                let title = document.createElement('p');
                    title.innerHTML = movie['title'];
                    title.classList = "text-center py-1"
                    card.appendChild(title);

                let popularity = document.createElement('p');
                    popularity.innerHTML = movie['popularity'] + ' views';
                    popularity.classList = "text-indigo-600 text-center py-1"
                    card.appendChild(popularity);
            })

        })
}


