<?php 
    session_start();
    $users = $_SESSION["users"];
    $pos = $_POST["num"];

   # elimino utente dal file users
    array_splice($users, $pos, 1);
    $msg;
    $_SESSION["users"] = $users;
    $jsonUs = json_encode($users);
    if(file_put_contents("../users.json", $jsonUs)){
        $msg = "Eliminato da utenti!";
        
    }else{
        $msg = "Elimina da utenti fallito";
    }

    #elimino le preferenze relative all'utente:
    $favUsers = $_SESSION["favList"];
    $user = trim($_SESSION["favList"][$pos]["username"]);
    for($i = 0; $i <= count($favUsers)-1; $i++){
        if($user ==  $favUsers[$i]["username"]){
            array_splice($favUsers, $i, 1);
            break;
        }
    }
    $_SESSION["favList"] = $favUsers;
    $jsonfav = json_encode($favUsers);
    if(file_put_contents("../favourites.json", $jsonfav)){
        $msg = "Eliminato da favoriti!";
        
    }else{
        $msg = "Operazione su favoriti fallita";
    }

    echo $msg;
?>