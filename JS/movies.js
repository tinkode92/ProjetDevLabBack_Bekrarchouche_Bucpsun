function displayMovies(movies) {
    containerMovies.innerHTML = "";
    movies.forEach(movie => {
        let card = document.createElement('div')
            containerMovies.appendChild(card)
            card.classList = 'w-[250px] bg-white rounded-t-lg rounded-b-lg drop-shadow-xl flex flex-col align-center'

        const img = document.createElement('img')
            img.classList = 'w-[250px] h-[350px] object-cover rounded-t-lg';
            img.src = 'https://image.tmdb.org/t/p/w500'+movie['poster_path'];
            card.appendChild(img);

        const title = document.createElement('p');
            title.innerHTML = movie['title'];
            title.classList = "text-center py-1"
            card.appendChild(title);

        const popularity = document.createElement('p');
            popularity.innerHTML = movie['popularity'] + ' views';
            popularity.classList = "text-yellow-600 text-center py-1"
            card.appendChild(popularity);

        const genre = document.createElement('p' );
            genre.innerHTML = movie['genre_ids'];
            genre.classList = "text-yellow-600 text-center py-1"
            card.appendChild(genre);
    });
}
