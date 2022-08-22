var animalPics = [];
var facedUp = [];
var points = 0;
var playAsGuest = false;

function startGame(){
    document.getElementById('startView').style.display = "none";
    document.getElementById('memoryView').style.display = "flex";
    requestData();
    startCountdown(90);
}

function startGameGuest(){
    playAsGuest = true;
    startGame();
}

function requestData(){
    let request = new XMLHttpRequest();
    request.open("GET", "https://zoo-animal-api.herokuapp.com/animals/rand/4");
    request.send();
    request.onload = () => {
        //console.log(request);
        if (request.status == 200){
            var jsonData = JSON.parse(request.response)
            console.log(jsonData);
            presentData(jsonData);

        } else {
            console.log('Request error')
        }
    }
}
//requestData();


function presentData(jsonData){
    var animals = jsonData;
    for(i = 0; i < animals.length; i++){
        animalPics.push(animals[i]['image_link']);
        animalPics.push(animals[i]['image_link']);
        facedUp.push(0);
        facedUp.push(0);
    }

    console.log(animalPics);
    shuffle(animalPics);
    for(i = 0; i < animalPics.length; i++){
        if(i<(animalPics.length/2)){
            document.getElementById('cardRow1').innerHTML += '<span id="card' + i +'" class="m-1 quizImage d-flex align-items-center justify-content-center" onClick="showCard(' + i+')">?</span>';
        } else {
            document.getElementById('cardRow2').innerHTML += '<span id="card' + i +'" class="m-1 quizImage d-flex align-items-center justify-content-center" onClick="showCard(' + i+')">?</span>';
        }
        
    }
   
}

var cardShown = 0;

function showCard(card){
        function refreshCards(){
            document.getElementById('cardRow1').innerHTML = '';
            document.getElementById('cardRow2').innerHTML = '';
            for(i = 0; i < animalPics.length; i++){
                facedUp[i] = 0;
                if(i<(animalPics.length/2)){
                    document.getElementById('cardRow1').innerHTML += '<span id="card' + i +'" class="m-1 quizImage d-flex align-items-center justify-content-center" onClick="showCard(' + i+')">?</span>';
                } else {
                    document.getElementById('cardRow2').innerHTML += '<span id="card' + i +'" class="m-1 quizImage d-flex align-items-center justify-content-center" onClick="showCard(' + i+')">?</span>';
                }
                
            }
            cardShown = 0;
        }
        
        function countCards(){
            cardShown = 0;
            for(i = 0; i< facedUp.length ; i++){
                if(facedUp[i] == 1){
                    cardShown++;
                }
            }
        }
    
        countCards();
    
        console.log(cardShown);
        if(cardShown <= 2){
            if(facedUp[card] != 1){
                document.getElementById('card' + card).innerHTML = '<img src="'+ animalPics[card] + '" id="card' + i +'" class="m-1 quizImage">';
                facedUp[card] = 1;
            } else {
                document.getElementById('card' + card).innerHTML = '?';
                facedUp[card] = 0;
            }
    
            countCards();
            console.log(cardShown);
    
            if(cardShown == 2){
                disableCards();
    
                var cards = [];
    
                //check cards faced up
                for(i = 0; i < facedUp.length; i++){
                    if(facedUp[i] == 1){
                        cardValues = [animalPics[i],i]
                        cards.push(cardValues);
                    }
                }
    
                //Check couple
                if(cards[0][0] == cards[1][0]){
                    points++;
                    console.log("win");
                    console.log(cards);
                    
                    //remove card1
                    for(i = 0; i < animalPics.length; i++){
                        if(animalPics[i] == cards[0][0]){
                            animalPics.splice(i,1);
                        }
                    }
                    //remove card2
                    for(i = 0; i < animalPics.length; i++){
                        if(animalPics[i] == cards[1][0]){
                            animalPics.splice(i,1);
                        }
                    }
    
    
                    facedUp.splice(1,2);//remove 2 elements from array 
    
                    
                }
                if(animalPics.length == 0){
                    window.setTimeout(endGame, 1000);
                } else {
                    window.setTimeout(refreshCards, 1000);
                }
                

            }
    
    
        }
    
        console.log(facedUp);
        console.log(animalPics);
    
}   


function disableCards(){
    for(i = 0; i < animalPics.length; i++){
        document.getElementById('card'+i).classList.add("disable");
    }
}

function updatePoints(){
    document.getElementById('Points').innerHTML = points + " pt";
}

function endGame(){
    if(playAsGuest){
        document.getElementById('memoryView').style.display = "none";
        document.getElementById('memoryEnd').style.display = "flex";
        document.getElementById('memoryEnd').innerHTML = '<h1>You won</h1><br><button class="btn btn-dark" onClick="closeGame()">Go Back</button>';
    }
    else{
        document.getElementById('memoryView').style.display = "none";
        document.getElementById('memoryEnd').style.display = "flex";
        var data = "memory&&points";
        ajax(data, "php/gamesManagement.php", "memoryEnd");
    }

}

function ajax(data, destination, response){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

          document.getElementById(response).style.display = 'flex';
          document.getElementById(response).innerHTML = this.responseText;
          //console.log("ciao");
      }
    };

    xmlhttp.open("POST", destination + "?" + data,true);
    xmlhttp.send();
  
}

function closeGame(){
    location.href = "memory.php";
    
}

function shuffle(array) {
    array.sort(() => Math.random() - 0.5);
  }



  function startCountdown(seconds) {
    let counter = seconds;
      
    const interval = setInterval(() => {
        document.getElementById('timer').innerHTML = counter;
      //console.log(counter);
      counter--;
        
      if (counter < 0 ) {
        clearInterval(interval);
        if(animalPics.length > 0){
            document.getElementById('memoryView').style.display = "none";
            document.getElementById('memoryEnd').style.display = "flex";
            document.getElementById('memoryEnd').innerHTML = '<h1>Game Over</h1><br><button class="btn btn-dark" onClick="closeGame()">Go Back</button>';
        }
        
      }
     
    }, 1000);
  }

