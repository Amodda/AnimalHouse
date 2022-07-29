var quest = ['What is the name of this animal?', 'What is the maximum weight of this animal?', 'This animal diet is based on?', "What is the latin name of this animal?"];

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
var questionNumber = Math.floor(Math.random() * 4);
var animalAnswer = [];
var questType = '';

function presentData(jsonData){
    var animals = jsonData;
    animalAnswer = animals[0];
   
    
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
    document.getElementById('quizImg').innerHTML = '<img src="'+ animalAnswer['image_link'] + '" id="quizImage">';
    document.getElementById('quizQuestion').innerHTML = '<p class="m-0 p-2">'+quest[questionNumber]+'</p>';;
    for(i = 0; i < 4; i++){
        document.getElementById('ans'+ i).innerHTML = animalAnswers[i];
    }
    //document.getElementById('quizAnswers').innerHTML = '<div class="d-flex flex-column"><div class="d-flex flex-row justify-content-around"><button class="w-50" id="ans0" onclick="answer(0)">' + animalAnswers[0]+ '</button><button class="w-50" id="ans1" onclick="answer(1)">' + animalAnswers[1]+ '</button></div><div class="d-flex flex-row justify-content-around"><button class="w-50" id="ans2" onclick="answer(2)">' + animalAnswers[2]+ '</button><button class="w-50" id="ans3" onclick="answer(3)">' + animalAnswers[3]+ '</button></div></div>'; 

    console.log(quest[questionNumber]);
    console.log(animalAnswers);
    console.log(animalAnswer);
    
}
//console.log(word);
function answer(answ){
    ans = document.getElementById('ans'+answ).innerHTML;

    if(ans == animalAnswer[questType]){
        document.getElementById('ans'+answ).style.background = 'green';
        for(i = 0; i <4; i++){
            document.getElementById('ans'+i).disabled = true;
        }
    } else {
        document.getElementById('ans'+answ).style.background = 'red';
        for(i = 0; i <4; i++){
            document.getElementById('ans'+i).disabled = true;
        }
    }
    console.log(ans);
}

function shuffle(array) {
    array.sort(() => Math.random() - 0.5);
  }

