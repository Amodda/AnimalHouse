<?php 
 session_start();
 $users = $_SESSION["users"];
 $new_name = $_POST["name"];
 $new_lname = $_POST["lname"];
 $new_mail = $_POST["email"];
 $new_user = $_POST["username"];
 $new_quiz = intval($_POST["quiz"]);
 $new_hang = intval($_POST["hang"]);
 $new_memo = intval($_POST["memo"]);
 $i = $_POST["i"];

 $users[$i]["name"]=$new_name;
 $users[$i]["lastname"]=$new_lname;
 $users[$i]["email"]=$new_mail;
 $users[$i]["username"]=$new_user;
 $users[$i]["gamesPoints"]["quiz"]=$new_quiz;
 $users[$i]["gamesPoints"]["hangman"]=$new_hang;
 $users[$i]["gamesPoints"]["memory"]=$new_memo;
 $_SESSION["users"] = $users;
 
 $jsonUs = json_encode($users);
 if(file_put_contents("../users.json", $jsonUs)){
     echo "Operazione riuscita!";
 }else{
     echo "Aggiornamento anagrafe fallito...";
 }
?>