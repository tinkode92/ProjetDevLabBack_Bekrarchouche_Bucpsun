const containerMovies = document.querySelector('.movie_container');
const id = new URLSearchParams(document.location.search).get('id');

let info = document.querySelector('.info_container')
let title_container = document.querySelector('.title')
let synop_container = document.querySelector('.synopsis')
let dollar_container = document.querySelector('.dollar')
let budget_container = document.querySelector('.budget')
let recette_container = document.querySelector('.recette')
let tagline = document.querySelector('.tagline')
let note = document.querySelector('.note')

fetch('https://api.themoviedb.org/3/movie/' + id + '?api_key='+api_key+'&language=fr-FR')
.then(response => response.json())
.then(data => {
    console.log(data)
    
    if(containerMovies.innerHTML !== null){
        containerMovies.innerHTML = '';
    }
    
    let card = document.createElement('div')
    containerMovies.appendChild(card)
    card.classList = 'w-[1200px] rounded-t-lg rounded-b-lg drop-shadow-lg flex align-center flex-row-reverse justify-end mx-3 gap-x-8'
    card.appendChild(info)
    card.id = "card"
    
    let img = document.createElement('img')
    img.classList = 'w-[300px] h-full object-cover rounded-l-lg rounded-r-lg';
    img.src = 'https://image.tmdb.org/t/p/w500'+ data['poster_path'];
    card.appendChild(img);
    
    let title = document.createElement('p');
    title.innerHTML = data['title'];
    title.classList = "py-1 w-full font-bold text-xl"
    title_container.appendChild(title);
    
    let genre_container = document.querySelector(".genre")
    
    data['genres'].forEach(element => {
        let genre = document.createElement('p')
        genre.innerHTML = element['name']
        genre.classList = "py-1"
        genre_container.appendChild(genre)
    })
    
    let date = document.createElement('p')
    
    date.innerHTML = '- ' + data['release_date'] + " -"  ;
    date.classList = "py-1"
    genre_container.appendChild(date);
    
    let time = document.createElement('p')
    time.innerHTML = Math.floor(data["runtime"]/60) + "h" + data["runtime"]%60 + 'min'
    time.classList = "py-1"
    genre_container.appendChild(time)
    
    let synopsis = document.createElement('p')
    synopsis.innerHTML = data["overview"]
    synopsis.classList = "py-1"
    synop_container.appendChild(synopsis)
    
    let budget = document.createElement('p')
    budget.innerHTML = '$'+data["budget"]
    budget.classList = "py-1"
    budget_container.appendChild(budget)
    
    let recette = document.createElement('p')
    recette.innerHTML = '$'+data["revenue"]
    recette.classList = "py-1"
    recette_container.appendChild(recette)
    
    if(data["vote_average"]) {
        note.innerHTML = "Recommandé à "+ Math.floor(data["vote_average"]*10) + "%"
        note.classList = "py-1 font-semibold"
        console.log(data["vote_average"])
    }
    
    if(data["overview"] === "") {
        synopsis.innerHTML = "Pas de syspnosis trouvé"
    }
    
    if(data["revenue"] === 0){
        recette.innerHTML = "Pas d'information"
    }
    if(data["budget"] === 0) {
        budget.innerHTML = "Pas d'information"
    }
    
    if(data["tagline"]) {
        tagline.innerHTML = data["tagline"]
        tagline.classList = "py-1 text-gray-800 italic"
        tagline.appendChild(tagline)
    }
    
    
})