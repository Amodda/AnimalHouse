<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/game.css">
    <link rel="stylesheet" href="css/quiz.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/quiz.js"></script>
    <title>AnimalCuriosity</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top mb-5 shadow">
        <div class="container-fluid my-1">
          <a class="navbar-brand " href="index.php">AnimalHouse <strong>Game</strong></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item active">
                <a class="nav-link" href="game.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Curiosity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Memory</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="hangman.html">Hangman</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

        <div class="container d-flex justify-content-center align-items-center my-4" >
          <div class="w-75 bg-light my-4 d-flex flex-column align-items-center  rounded shadow" id="quiz">
              <div class="d-flex w-75 m-3 justify-content-center align-items-center">
                  <h4 class="mx-3">AnimalQuiz</h4>
                 
              </div>
              <div class="flex-column align-items-center justify-content-center my-4 w-100" style="display: flex;" id="startView">
                <p class="w-50 mb-4">Get the correct answer of the next 10 questions and try your best to get the highest score!</p>
                <?php
                  if(isset($_SESSION['user'])){
                    echo '<button class="btn btn-dark" onClick="startGame()" id="hangmanStartButton">Start Game</button>';
                  } else {
                    echo '<button class="btn btn-dark" onClick="startGameNoLogin()" id="hangmanStartButton">Play without account</button>';
                  }
                ?>
              </div>
              
              <div class="w-75 flex-column justify-content-center align-items-center my-4" style="display: none;" id="quizView">
                  <div class="w-100 d-flex justify-content-center align-items-center my-3" >
                    <h5 id="quizPoints"></h5>
                  </div>
                  <div class="my-2" id="quizImg">
                    
                  </div>
                  <div class="d-flex ">
                    <h5 id="quizQuestion"></h5>
                  </div>
                  <div class="w-100 flex-column align-items-center justify-content-center my-4" style="display: flex;" id="quizAnswers">

                    <div class="w-100 d-flex flex-row justify-content-center">
                      <button class="w-100 m-1 btn rounded border shadow-sm" id="ans0" onClick="answer(0)"></button>
                      <button class="w-100 m-1 btn rounded border shadow-sm" id="ans1" onClick="answer(1)"></button>
                    </div>

                    <div class="w-100 d-flex flex-row justify-content-center">
                      <button class="w-100 m-1 btn rounded border shadow-sm" id="ans2" onClick="answer(2)"></button>
                      <button class="w-100 m-1 btn rounded border shadow-sm" id="ans3" onClick="answer(3)"></button>
                    </div>

                  </div>
                  <div class="w-100 d-flex flex-row justify-content-end align-items-center">
                    <button class="btn btn-dark" id="nextQuestBtn" onClick="nextQuestion()" disabled>Next</button>
                  </div>


              </div>
              <div class="w-75 flex-column justify-content-center align-items-center my-4" id="quizEnd" style="display: none;">
                  
              </div>
      
          </div>
      </div>



</body>
</html>