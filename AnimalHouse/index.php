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
        <div class="container-fluid ">
          <a class="navbar-brand " href="index.php">AnimalHouse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

              <li class="nav-item">
                <a class="nav-link active" href="#">Home</a>
              </li>
              <?php
                    if(!isset($_SESSION['user'])){
                        echo '<li class="nav-item ">';
                            echo '<a class="nav-link" href="signin.php">Sign in</a>';
                        echo '</li>';

                    }
                    if(isset($_SESSION['user'])){
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="store.php">Store</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="forum.php">Forum</a>';
                        echo '</li>';
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome '.$_SESSION['user']['name'].'</a>';
                        echo '<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">';
                        echo '<li><a class="dropdown-item" href="php/authentication.php?logout">Logout</a></li>';
                        if($_SESSION['user']['type'] == "admin"){
                            echo '<li><a class="dropdown-item" href="adminDashboard.php?logout">Admin Panel</a></li>';
                        }
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

    <div class="container d-flex flex-column align-items-center my-5">
        <div id="communityGames">
            <div class="w-100 d-flex align-items-center justify-content-center mt-5">
                <h4 class="mt-3">Games</h4>
            </div>
            <div class="d-flex align-items-center my-3" id="gamesList">
                <div class="gameCard shadow border">
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
                            <a class="w-50 btn btn-success" href="animalCuriosity.html">Start</a>
                        </div>
                    </div>

                </div>
                <div class=" gameCard mx-3 shadow border">
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
                            <a class="w-50 btn btn-success" href="">Start</a>
                        </div>
                    </div>

                </div>
                <div class=" gameCard shadow border">
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
                            <a class="w-50 btn btn-success" href="hangman.html">Start</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php

    if(isset($_SESSION['user'])){
        $jsonData = file_get_contents("users.json");
        $users = json_decode($jsonData, true);
        
        function sortQuiz($a, $b) {
            return $a['gamesPoints']['quiz'] > $b['gamesPoints']['quiz'];
        }
        function sortMemory($a, $b) {
            return $a['gamesPoints']['memory'] > $b['gamesPoints']['memory'];
        }
        function sortHangman($a, $b) {
            return $a['gamesPoints']['hangman'] > $b['gamesPoints']['hangman'];
        }
        //leaderboard
        echo '<div class="container-fluid d-flex flex-column bg-dark">';
            echo '<div class="w-100 d-flex align-items-center justify-content-center my-3 mt-5">';
                echo '<h4 class="text-white mt-3">Leaderboard</h4>';
            echo '</div>';

            echo '<div class="container d-flex w-100 align-items-center justify-content-center flex-row">';
                echo '<div class="d-flex w-100 justify-content-around my-4" id="gamesleaderboard">';
                    echo '<div class="d-flex flex-column align-items-center justify-content-center" id="quizLeaderboard">';
                    echo '<h5 class="text-white">AnimalQuiz</h5>';
                    echo '<table class="table table-dark table-hover my-3">';
                        echo '<tr><th>Place</th><th>User</th><th>Points</th></tr>';
                        usort($users, 'sortQuiz');
                        $place = 1;
                        for($i = count($users)-1; $i >= count($users)-5; $i--){
                            echo '<tr><td>'.$place.'</td><td>'.$users[$i]['username'].'</td><td>'.$users[$i]['gamesPoints']['quiz'].'</td></tr>';
                            $place++;
                        }
                    echo '</table>';
                    echo '</div>';
                    echo '<div class="d-flex flex-column align-items-center justify-content-center" id="memoryLeaderboard">';
                    echo '<h5 class="text-white">Memory</h5>';
                    echo '<table class="table table-dark table-hover my-3">';
                        echo '<tr><th>Place</th><th>User</th><th>Points</th></tr>';
                        usort($users, 'sortMemory');
                        $place = 1;
                        for($i = count($users)-1; $i >= count($users)-5; $i--){
                            echo '<tr><td>'.$place.'</td><td>'.$users[$i]['username'].'</td><td>'.$users[$i]['gamesPoints']['memory'].'</td></tr>';
                            $place++;
                        }
                    echo '</table>';
                    echo '</div>';
                    echo '<div class="d-flex flex-column align-items-center justify-content-center" id="hangmanLeaderboard">';
                    echo '<h5 class="text-white">Hangman</h5>';
                    echo '<table class="table table-dark table-hover my-3">';
                        echo '<tr><th>Place</th><th>User</th><th>Points</th></tr>';
                        usort($users, 'sortHangman');
                        $place = 1;
                        for($i = count($users)-1; $i >= count($users)-5; $i--){
                            echo '<tr><td>'.$place.'</td><td>'.$users[$i]['username'].'</td><td>'.$users[$i]['gamesPoints']['hangman'].'</td></tr>';
                            $place++;
                        }
                    echo '</table>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        
        //E-Commerce
        echo '<div class="container-fluid d-flex flex-column">';

            echo '<div class="container d-flex w-100 align-items-center justify-content-around flex-row ">';
                echo '<div class="w-100 d-flex flex-column justify-content-start my-5">';
                    echo '<h1>E-Commerce</h1>';
                    echo '<h5>Do you need anything for your animal? Take a look at our store!</h5>';
                    echo '<div class="container w-100 d-flex align-items-center justify-content-end mt-5">';
                    echo '<a class="btn btn-success" href="store.php">Open store <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bag" viewBox="0 0 20 20">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                      </svg></a>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="w-100 d-flex flex-column align-items-center justify-content-center my-5">';
                    //echo '<a class="btn" style="font-size: 30px; padding: 1em; background: lightgreen; opacity: 0.7; border-radius: 1em;" href="">OPEN FORUM</a>';
                    echo '<img src="animalBG.jpeg" style="width: 100%;">';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        //Forum
        echo '<div class="container-fluid d-flex flex-column bg-dark text-white">';

            echo '<div class="container d-flex w-100 align-items-center justify-content-around flex-row ">';
                echo '<div class="w-100 d-flex flex-column align-items-center justify-content-center m-5">';
                //echo '<a class="btn" style="font-size: 30px; padding: 1em; background: lightgreen; opacity: 0.7; border-radius: 1em;" href="">OPEN FORUM</a>';
                    echo '<img src="animalBG.jpeg" style="width: 100%;">';
                echo '</div>';
                echo '<div class="w-100 d-flex flex-column justify-content-start my-5">';
                    echo '<h1>Forum</h1>';
                    echo '<h5>Share your stories with other users</h5>';
                    echo '<div class="w-100 d-flex align-items-center justify-content-center mt-5">';
                    echo '<a class="btn btn-success" href="forum.php">Open forum <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 20 20">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                      </svg></a>';
                    echo '</div>';
                echo '</div>';

            echo '</div>';
        echo '</div>';
    } else {
        //Locked view 
        echo '<div class="container-fluid d-flex flex-column bg-dark">';
        echo '<div class="w-100 d-flex align-items-center justify-content-center my-3">';
            echo '<h4 class="text-white">Community</h4>';
        echo '</div>';
        echo '<div class="container d-flex w-100 flex-row align-items-center text-white my-3">';
            echo '<div class="w-100 d-flex flex-column align-items-center justify-content-center" style=" opacity: 0.7">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/></svg>';
                echo '<p class="my-3" style="font-size: 25px;">Sign in to unlock content</p>';
            echo '</div>';
            echo '<div class="w-100 d-flex flex-column align-items-center justify-content-start">';
                echo '<div class="m-1 w-100">';
                    echo '<h5>Games leaderboard</h5>';
                    echo '<p class="mx-3" style="opacity: 0.7">Get access to the games leaderboard. Play your game and get to the top.</p>';
                echo '</div>';
                echo '<div class="m-1 w-100">';
                    echo '<h5>Forum</h5>';
                    echo '<p class="mx-3" style="opacity: 0.7">Share posts about animals with another users. </p>';
                echo '</div>';
                echo '<div class="m-1 w-100">';
                    echo '<h5>E-Commerce</h5>';
                    echo '<p class="mx-3" style="opacity: 0.7">Get access to an entire list of animal products that you can buy with a simple click</p>';
            echo '</div>';
        echo '</div>';
        echo '</div>';
        
    echo '</div>';
    }
    ?>




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