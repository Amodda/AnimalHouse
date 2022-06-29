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
    <link rel="stylesheet" href="css/animalHouse.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title> </title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
        <div class="container-fluid my-1">
          <a class="navbar-brand " href="index.php">AnimalHouse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

              <li class="nav-item">
                <a class="nav-link active" href="#">Home</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="signin.php">Sign in</a>
              </li>
              <?php
                    if(isset($_SESSION['user'])){
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome '.$_SESSION['user']['name'].'</a>';
                        echo '<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">';
                        echo '<li><a class="dropdown-item" href="php/authentication.php?logout">Logout</a></li>';
                        echo '</ul>';
                        echo '</li>';
                    }
                ?>
            </ul>
          </div>
        </div>
    </nav>


    <div class="d-flex flex-row align-items-center w-100" style="height: 100vh" id="backgroundImg">
        <div class="w-100 d-flex flex-row align-items-center" style="height: 100vh; background: rgb(0,0,0,0.5)">
            <div class=" w-50 d-flex align-items-center justify-content-end mx-4">
                <h1 class="text-white">Welcome to Animal House</h1>
            </div>
            <div class="w-50 d-flex align-items-center justify-content-center mx-4">
              <a href="#communityGames" class="btn shadow" id="btnStart">Start Now</a>
            </div>
        </div>
    </div>

    <div class="container d-flex flex-column align-items-center my-3">
        <div id="communityGames">
            <div class="w-100 d-flex align-items-center justify-content-center">
                <h4>Community</h4>
            </div>
            <div class="d-flex flex-row align-items-center my-3">
                <div class="bg-light gameCard shadow">
                    <div class="m-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <h4>AnimalCuriosity</h4>
                            
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="" alt="">
                        </div>
                        <div>
                            <p>AnimalCuriosity is a funny game where you can learn a lot of things you didn't know about animals.</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <a class="w-50 btn btn-dark" href="animalCuriosity.html">Start</a>
                        </div>
                    </div>

                </div>
                <div class="bg-light gameCard mx-3 shadow">
                    <div class="m-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <h4>Memory</h4>
                            
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="" alt="">
                        </div>
                        <div>
                            <p>Play memory with random animals! You might love it!</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <a class="w-50 btn btn-dark" href="">Start</a>
                        </div>
                    </div>

                </div>
                <div class="bg-light gameCard shadow">
                    <div class="m-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <h4>Hangman</h4>
                            
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="" alt="">
                        </div>
                        <div>
                            <p>AnimalCuriosity is a funny game where you can find out a lot of things you didn't know about animals.</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <a class="w-50 btn btn-dark" href="hangman.html">Start</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <footer class="bg-light text-center w-100 mt-4" >


        <!-- Copyright -->
        <div class="text-center p-3 ">
          © 2022 Copyright:
          <a class="text-dark" href="">Alessandro Modelli</a>
        </div>
        <!-- Copyright -->
      </footer>


</body>
</html>