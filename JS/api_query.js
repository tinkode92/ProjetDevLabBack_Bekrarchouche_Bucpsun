const api_key = "e63fb2ad752c2e17625b63265a27a32a"

function getGenres() {
    return fetch("https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key + '&language=fr-FR')
        .then(response => response.json());
}

function getMoviesForGenre(genre, pagination) {
    return fetch(`https://api.themoviedb.org/3/discover/movie?api_key=${api_key}&with_genres=${genre}&page=${pagination}` + '&language=fr-FR' + "&sort_by=popularity.desc")
        .then(response => response.json())
}

function getMoviesForSearch(search, pagination) {       
    return axios
        .get(`https://api.themoviedb.org/3/search/movie?api_key=${api_key}&query=${search}&page=${pagination}&language=fr-FR`)
        .then(res => res.data);
}