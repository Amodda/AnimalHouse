<?php 
    session_start();
    $users = $_SESSION["users"];
    $pos = $_POST["num"];
    
    array_splice($users, $pos, $pos);

   
    $_SESSION["users"] = $users;
    $jsonUs = json_encode($users);
    if(file_put_contents("../usersTest.json", $jsonUs)){
        echo "Operazione riuscita!";
        
    }else{
        echo "Aggiornamento password fallito...";
    }
?>