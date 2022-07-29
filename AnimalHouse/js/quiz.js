var quest = ['What is the name of this animal?', 'What is the maximum weight of this animal?', 'This animal diet is based on?', "What is the latin name of this animal?"];
var questionNumber;
var animalAnswer = []; //Animal with correct answer
var questType = '';
var points = 0;
var questCounter = 3;

function startGame(){
    document.getElementById('startView').style.display = "none";
    document.getElementById('quizView').style.display = "flex";
    requestData();
    //setLives();
    
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
    animalAnswer = animals[0];
   
    questionNumber = Math.floor(Math.random() * 4);
    
    var animalAnswers = [];
    if(questionNumber == 0){
        questType = 'name';
    } else if(questionNumber == 1){
        questType = 'weight_max';
    } else if(questionNumber == 2){
        questType = 'diet';
    } else if(questionNumber == 3){
        questType = 'latin_name';
    }

    for(i = 0; i < 4; i++){
        animalAnswers.push(animals[i][questType]);
    }
    shuffle(animalAnswers);

    updatePoints();
    document.getElementById('quizImg').innerHTML = '<img src="'+ animalAnswer['image_link'] + '" id="quizImage">';
    document.getElementById('quizQuestion').innerHTML = '<p class="m-0 p-2">'+quest[questionNumber]+'</p>';

    for(i = 0; i < 4; i++){
        document.getElementById('ans'+ i).innerHTML = animalAnswers[i];
    }

    //console.log(quest[questionNumber]);
    console.log(animalAnswers);
    console.log(animalAnswer);
    
}

function answer(answ){
    ans = document.getElementById('ans'+answ).innerHTML;

    if(ans == animalAnswer[questType]){
        points++;
        document.getElementById('ans'+answ).style.background = 'green';
        disableAnswerButtons();

    } else {
        if(points > 0){
            points--;
        }
        document.getElementById('ans'+answ).style.background = 'red';
        disableAnswerButtons();
    }
    console.log(ans);

    document.getElementById('nextQuestBtn').disabled = false; //Enable next question button
}

function nextQuestion(){
    if(questCounter > 0){
        questCounter--;
        document.getElementById('nextQuestBtn').disabled = true;
        for(i = 0; i <4; i++){
            document.getElementById('ans'+i).disabled = false;
            document.getElementById('ans'+i).style.background = '';
        }
        requestData();
    } else {
        updatePoints();
        endGame();
    }

    
}

function disableAnswerButtons(){
    for(i = 0; i <4; i++){
        document.getElementById('ans'+i).disabled = true;
    }
}

function updatePoints(){
    document.getElementById('quizPoints').innerHTML = points + " pt";
}

function endGame(){
    document.getElementById('quizView').style.display = "none";
    document.getElementById('quizEnd').style.display = "flex";
    var data = "quiz&&points=" + points;
    ajax(data, "php/gamesManagement.php", "quizEnd");
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
    location.href = "animalQuiz.php";
    
}

function shuffle(array) {
    array.sort(() => Math.random() - 0.5);
  }

