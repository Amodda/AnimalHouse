<?php 
    session_start();
    $users = $_SESSION["users"];
    $pos = $_POST["num"];
    
    unset($users[$pos]);

   
    $_SESSION["users"] = $users;
    $jsonUs = json_encode($users);
    if(file_put_contents("../usersTest.json", $jsonUs)){
        echo "Operazione riuscita!";
    }else{
        echo "Aggiornamento password fallito...";
    }
?>