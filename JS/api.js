// api url
const api_key = "e63fb2ad752c2e17625b63265a27a32a"
const api_url =
    "https://api.themoviedb.org/3/genre/movie/list?api_key=" + api_key;


async function getapi(url) {

    // Stockage des données de l'api depuis son url
    const response = await fetch(url);

    // Stockage des données en JSON
    var data = await response.json();
    console.log(data);

    show(data);
}
// On appel la fonction
getapi(api_url);


// Function to define innerHTML for HTML table
function show(data) {
    let tab = ``;

    // Loop to access all rows
    for (let r of data.genres) {
        tab += `<button class="flex flex-col text-gray-400 p-2 w-[125px]" type="button">${r.name}</button>`;
    }
    // Setting innerHTML as tab variable
    document.getElementById("categories").innerHTML = tab;
}
