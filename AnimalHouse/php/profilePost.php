<?php 
    session_start();
    $newFav = $_POST["newArr"];
    echo "prova: ".$newFav[0];
   
    for($i = 0; $i <= count($_SESSION['favList'])-1; $i++){
        if($_SESSION["user"]["username"] ==  $_SESSION["favList"][$i]["username"]){
            $_SESSION['favList'][$i]["preferences"] = $newFav;
        }
    }
    
    $jsonUs = json_encode($_SESSION["favList"]);
    if(file_put_contents("../favourites.json", $jsonUs)){
        echo "Operazione riuscita!";
    }else{
        echo "Aggiornamento password fallito...";
    }
    
?>