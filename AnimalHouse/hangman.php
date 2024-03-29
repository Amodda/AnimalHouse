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
    <link rel="stylesheet" href="css/hangman.css">
    <link rel="stylesheet" href="css/game.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/hangman.js"></script>
    <title>AnimalCuriosity</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top mb-5 shadow">
        <div class="container-fluid">
          <a class="navbar-brand " href="index.php">AnimalHouse <strong>Game</strong></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Games</a>
                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
                  <li><a class="dropdown-item" href="animalQuiz.php">Quiz</a></li>
                  <li><a class="dropdown-item" href="#">Memory</a></li>
                  <li><a class="dropdown-item" href="#">Hangman</a></li>

                </ul>
              </li>
              <?php
                    if(!isset($_SESSION['user'])){
                        echo '<li class="nav-item ">';
                            echo '<a class="nav-link" href="signin.php">Sign in</a>';
                        echo '</li>';

                    }
                    if(isset($_SESSION['user'])){
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome '.$_SESSION['user']['name'].'</a>';
                        echo '<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">';
                        echo '<li><a class="dropdown-item" href="php/authentication.php?logout">Logout</a></li>';
                        if($_SESSION['user']['type'] == "admin"){
                            echo '<li><a class="dropdown-item" href="adminDashboard.php">Admin Panel</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                ?>
            </ul>
          </div>
        </div>
    </nav>

        <div class="container d-flex justify-content-center align-items-center my-4" >
            <div class="w-75 bg-light my-4 d-flex flex-column align-items-center  rounded shadow" id="curiosity">
                <div class="d-flex w-75 m-3 justify-content-center align-items-center">
                    <h4 class="mx-3">Hangman</h4>
                   
                </div>
                <div class="flex-column align-items-center justify-content-center my-4 w-100" style="display: flex;" id="startGame">
                  <p class="w-50 mb-4">Guess the word letter-by-letter and get your win! But be carefull, you only have 10 lives to guess it.</p>
                  <?php
                  if(isset($_SESSION['user'])){
                    echo '<button class="btn btn-dark" onClick="startGame()" id="hangmanStartButton">Start Game</button>';
                  } else {
                    echo '<button class="btn btn-dark" onClick="startGameGuest()" id="hangmanStartButton">Play as Guest</button>';
                  }
                ?>
                </div>
                
                <div class="w-75 flex-column justify-content-center align-items-center" style="display: none;" id="hangman">
                    <div class="my-2" id="hangmanImg">
                      
                    </div>
                    <div class="d-flex ">
                      <h4 id="word"></h4>
                    </div>
                    <div class="flex-column align-items-center justify-content-center" style="display: flex;" id="hangmanTools">
                      <div class="my-4 w-100 d-flex flex-row align-items-center justify-content-center">
                        <input type="text" maxlength="1" class="form-control w-50" placeholder="Type Letter" id="letter">
                        <button class="btn btn-dark w-50 mx-1" onClick="addLetter()">Add Letter</button>
                      </div>
                      <div class="d-flex flex-row justify-content-start align-items-center w-75 my-3" id="hangmanUsedLetters">

                      </div>
                      <div class="flex-column align-items-center justify-content-center" style="display: flex;">
                        <p id="livesCount"></p>
                      </div>
                      <div class="d-flex flex-row justify-content-around align-items-center w-75 mb-3" id="hangmanLives">

                      </div>
                    </div>
                    <div class="w-75 flex-column justify-content-center m-3" id="hangmanWinner" style="display: none;">

                    </div>

                </div>
        
            </div>
        </div>



</body>
</html>