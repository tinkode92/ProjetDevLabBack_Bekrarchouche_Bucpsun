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

        let link = document.createElement('a');
        link.href = "film.php?" + "&id=" + movie['id'] + "&name=" + movie['title']
        link.classList = "h-full w-full absolute"
        card.appendChild(link)
    });
}