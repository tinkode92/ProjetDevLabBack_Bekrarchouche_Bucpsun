getGenres().then(data =>  {
    for (let r of data.genres) {
        let button = document.createElement('button');
            button.innerHTML = r['name'];
            button.classList = 'bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded ease-in-out duration-150';

        button.addEventListener('click', ()=> {
            displayMoviesForGenre(r['id'])
            let genre_title = document.querySelector('#H1_genre')
            genre_title.innerHTML = 'Categorie: ' + r['name']
        })

        PaginationNext.addEventListener('click', ()=> {
            button.addEventListener('click', ()=> {
                displayMoviesForGenre(r['id']);
            })
        })

        document.querySelector('.genre_container').appendChild(button)
    }
});

const PaginationPrev = document.querySelector("#prev")
const PaginationNext = document.querySelector("#next")
const LastPage = document.querySelector("#before")
const CurrentPage = document.querySelector("#current")
const AfterPage = document.querySelector('#after')
const containerMovies = document.querySelector('.movie_container');
let avant = 0
let pagination = 1
let apres = 2
let lastGenre;

PaginationNext.addEventListener('click', () => {
    pagination++
    avant++
    apres++
    displayMoviesForGenre()
    CurrentPage.innerHTML = pagination
    LastPage.innerHTML = avant
    AfterPage.innerHTML = apres
});

PaginationPrev.addEventListener('click', () => {
    if (pagination > 0) {
        pagination--
        avant--
        apres--
        displayMoviesForGenre()
        LastPage.innerHTML = avant
        AfterPage.innerHTML = apres
        CurrentPage.innerHTML = pagination
    }
});

function displayMoviesForGenre(genre = lastGenre) {
    lastGenre = genre;
    getMoviesForGenre(genre, pagination)
        .then(data => displayMovies(data.results))
}