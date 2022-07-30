var word;
var emptyWord = [];
var lives = 10;
var usedLetters = [];

function startGame(){
    document.getElementById('startGame').style.display = "none";
    document.getElementById('hangman').style.display = "flex";
    requestData();
    setLives();
    
}

function startGameGuest(){
    playAsGuest = true;
    startGame();
}

function requestData(){
    let request = new XMLHttpRequest();
    request.open("GET", "https://zoo-animal-api.herokuapp.com/animals/rand");
    request.send();
    request.onload = () => {
        //console.log(request);
        if (request.status == 200){
            var jsonData = JSON.parse(request.response)
            //console.log(jsonData);
            presentData(jsonData);

        } else {
            console.log('Request error')
        }
    }
}
//requestData();


function presentData(jsonData){
    var animal = jsonData;
    word = animal['name'];
    img = animal['image_link']
    word = word.toUpperCase();
    console.log(word.length);
    
    for(i = 0; i<word.length; i++){
        emptyWord.push('_',); 
        if(i == 0){
            emptyWord[i] = word.charAt(i);
            usedLetters.push(word.charAt(i));
            
        }
        if(i == word.length-1){
            emptyWord[i] = word.charAt(i);
            usedLetters.push(word.charAt(i));
        }
            //emptyWord.push(name.charAt(i));
            if(word.charAt(i) == ' '){
                console.log("space");
                emptyWord[i] = "-"; 
            }
            if(word.charAt(i) == '-'){
                console.log("-");
                emptyWord[i] = "-"; 
            }
            
            if(word.charAt(i) == "'"){
                emptyWord[i] = "'"; 
            }
                if(word.charAt(i) == word.charAt(0)){
                    emptyWord[i] = word.charAt(0); 
                }
                if(word.charAt(i) == word.charAt(word.length-1)){
                    emptyWord[i] = word.charAt(word.length-1); 
                }
                
                
            
            
        
        
    }
    //emptyWord = emptyWord.join(' ');
    document.getElementById('hangmanImg').innerHTML = '<img src="'+ img+ '" id="hangmanImage">';
    document.getElementById('word').innerHTML = emptyWord.join(' ');
    setupUsedLetters();
    //document.getElementById('animalInfo').innerHTML = '<div class="w-100 my-4 d-flex flex-row justify-content-start"><div class=""><img src="' + animal['image_link']+'" id="animalImg"></div><div class="d-flex flex-column mx-4"><div class="w-100 d-flex"><div><strong>Type: </strong>' + animal['animal_type'] + '</div></div><div class="w-100 d-flex"><div><strong>Name: </strong>' + animal['name'] + '</div></div><div><strong>Latin name: </strong>' + animal['latin_name'] + '</div><div><strong>Diet: </strong>' + animal['diet'] + '</div></div></div>';
    console.log(word)
    console.log(emptyWord)
}
//console.log(word);

function setLives(){
    document.getElementById('hangmanLives').innerHTML = '';
    for(i = 0; i< lives; i++){

        document.getElementById('hangmanLives').innerHTML += '<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg></span>';
    }
    document.getElementById('livesCount').innerHTML = lives + " lives";
}

function addLetter(){
    var letter= document.getElementById('letter').value.toUpperCase();
    console.log(letter);
    if(letter != '' || letter != ' '){

    if(!usedLetters.includes(letter)){
        if(word.indexOf(letter) !== -1){
            for(i = 0; i<word.length; i++){
                if(word.charAt(i) == letter){
                    emptyWord[i] = letter;
                }
            }
            console.log(emptyWord.join(' '));
            
            document.getElementById('word').innerHTML = emptyWord.join(' ');
            console.log(emptyWord);
        } else {
            //console.log("no");
            lives--;
            setLives();
        }
        updateUsedLetters(letter);
        document.getElementById('letter').value = "";
        if(emptyWord.indexOf('_') !== -1){
    
        } else {
            document.getElementById('hangmanTools').style.display = "none";
            document.getElementById('hangmanWinner').innerHTML += '<div><h1>You win!</h1></div>'
        }
    }
    
    }

}

function updateUsedLetters(letter){
    usedLetters.push(letter);
    setupUsedLetters();
    //document.getElementById('hangmanUsedLetters').innerHTML += '<span></span>'
}

function setupUsedLetters(){
    document.getElementById('hangmanUsedLetters').innerHTML = '';
    for(i = 0; i< usedLetters.length; i++){

        document.getElementById('hangmanUsedLetters').innerHTML += '<span class="mx-3">' + usedLetters[i]+'</span>';
    }
}