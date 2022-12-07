// api url
const api_key = "e63fb2ad752c2e17625b63265a27a32a"
let api_query_film_by_id = "https://api.themoviedb.org/3/discover/movie?api_key=" + api_key + "&with_genres=" + "16";
let api_query_categories = "https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key;

async function getapi(url) {

    // Stockage des données de l'api depuis son url
    const response = await fetch(url);

    // Stockage des données en JSON
    var data = await response.json();
    console.log(data);

    show(data);
}
// On appel la fonction
getapi(api_query_categories);
getapi(api_query_film_by_id);



// Fonction pour afficher les données en les insérant dans la variable tab à l'aide d'une boucle for
function show(data) {
    let cat = ``;
    let film = ``;
    // Boucle pour accéder aux colonnes du tableaux genres
    for (let r of data.results) {
        cat += `<button class="flex flex-col text-gray-400 p-2 w-[125px]" type="button" id="${r.id}">${r.name}</button>`;
    }
    for (let f of data.results) {
        film += `<img class="h-[200px]" src="https://image.tmdb.org/t/p/w500/${f.poster_path}" alt="poster film">`;
    }



    // Afficher sur une page à l'aide d'innerHTML les données dans nos variables
    document.querySelector("#categories").innerHTML = cat;
    document.querySelector("#poster").innerHTML = film;
}
