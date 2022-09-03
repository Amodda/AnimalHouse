<?php 
    session_start();
    $newFav = $_POST["newArr"];
    $newUsername = trim($_POST["newuser"]);
    # se vengo da profilo dell'utente, il vecchio username è direttamente la variabile di sessione
    # altrimenti se vengo dal pannello admin allora è l'username selezionato
    if(trim($_POST["username"]) == "flag"){
        $oldUsername = trim($_SESSION["user"]["username"]);
    }else{
        $oldUsername = $_POST["username"];
    }
    
    
    for($i = 0; $i <= count($_SESSION['favList'])-1; $i++){
        if($oldUsername ==  $_SESSION["favList"][$i]["username"]){
            $_SESSION['favList'][$i]["username"] = $newUsername;
            $_SESSION['favList'][$i]["preferences"] = $newFav;
        }
    }
    if($newUsername != $oldUsername){
        $_SESSION["user"]["username"] = $newUsername;
    }
    
    $jsonUs = json_encode($_SESSION["favList"]);
    if(file_put_contents("../favourites.json", $jsonUs)){
        echo "Operazione riuscita!";
    }else{
        echo "Aggiornamento password fallito...";
    }
    
?>