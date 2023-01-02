const PaginationPrev = document.querySelector("#prev")
const PaginationNext = document.querySelector("#next")
const CurrentPage = document.querySelector("#current")
const searchInput = document.getElementById('search-input');
const containerMovies = document.querySelector('.movie_container');

let pagination = 1
const search = new URLSearchParams(document.location.search).get('query');

searchInput.value = search;

displayMoviesForSearch();

PaginationNext.addEventListener('click', () => {
    pagination++
    displayMoviesForSearch()
    CurrentPage.innerHTML = pagination
});

PaginationPrev.addEventListener('click', () => {
    if (pagination > 0) {
        pagination--
        displayMoviesForSearch()
        CurrentPage.innerHTML = pagination
    }
});

function displayMoviesForSearch() {
    getMoviesForSearch(search, pagination)
        .then(data => displayMovies(data.results))
}