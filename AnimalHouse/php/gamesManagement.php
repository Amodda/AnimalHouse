<?php
session_start();

$jsonData = file_get_contents("../users.json");
$users = json_decode($jsonData, true);

if(isset($_GET['quiz'])){

    $user = $_SESSION['user']['username'];
    $points = $_GET['points'];

    for($i = 0; $i < count($users); $i++){
        if($users[$i]['username'] == $user){
            $users[$i]['gamesPoints']['quiz'] += $points;
            $pointsCounter = $users[$i]['gamesPoints']['quiz'];
            break;
        }
    }

    
    $json = json_encode($users);
    //write json to file

    if (file_put_contents("../users.json", $json)){
        echo '<h1>Congratulation, your points have been updated!</h1><br>';
        echo '<h3>Current points: '.$pointsCounter.'</h3>';
        echo '<button class="btn btn-dark" onClick="closeGame()">Go Back</button>';
    } else {
        echo "Oops! Error updating points...";
    }
    
}

if(isset($_GET['hangman'])){

    $user = $_SESSION['user']['username'];

    for($i = 0; $i < count($users); $i++){
        if($users[$i]['username'] == $user){
            $users[$i]['gamesPoints']['hangman'] += 1;
            $pointsCounter = $users[$i]['gamesPoints']['hangman'];
            break;
        }
    }

    
    $json = json_encode($users);
    //write json to file

    if (file_put_contents("../users.json", $json)){
        echo '<h2>Congratulation you won!</h2><br>';
        echo '<h3>Current points: '.$pointsCounter.'</h3>';
        echo '<button class="btn btn-dark" onClick="closeGame()">Go Back</button>';
    } else {
        echo "Oops! Error updating points...";
    }
    
}

if(isset($_GET['memory'])){

    $user = $_SESSION['user']['username'];

    for($i = 0; $i < count($users); $i++){
        if($users[$i]['username'] == $user){
            $users[$i]['gamesPoints']['memory'] += 1;
            $pointsCounter = $users[$i]['gamesPoints']['memory'];
            break;
        }
    }

    
    $json = json_encode($users);
    //write json to file

    if (file_put_contents("../users.json", $json)){
        echo '<h2>Congratulation you won!</h2><br>';
        echo '<h3>Current points: '.$pointsCounter.'</h3>';
        echo '<button class="btn btn-dark" onClick="closeGame()">Go Back</button>';
    } else {
        echo "Oops! Error updating points...";
    }
    
}

?>