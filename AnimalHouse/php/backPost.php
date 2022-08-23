<?php 
    session_start();
    $users = $_SESSION["users"];
    $pos = $_POST["num"];
    $newP = $_POST["npwd"];
    $oldP = $_POST["olpwd"];
    
    // aggiungi codifica password
    if(password_verify($oldP, $users[$pos]["password"]) === true){
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
    }else{
        echo "Vecchia password non corretta";
    }
?>