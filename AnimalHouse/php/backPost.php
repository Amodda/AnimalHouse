<?php 
    session_start();
    $users = $_SESSION["users"];
    $pos = $_POST["num"];
    $newP = json_encode($_POST["npwd"]);
    // aggiungi codifica password
    $password_hash = password_hash($newP, PASSWORD_BCRYPT);
    $users[$pos]['password'] = $password_hash;
     
    $newUsers = $users;
    $_SESSION["users"] = $newUsers;
    $jsonUs = json_encode($newUsers);
    if(file_put_contents("../usersTest.json", $jsonUs)){
        echo "Operazione riuscita!";
    }else{
        echo "Aggiornamento password fallito...";
    }
?>