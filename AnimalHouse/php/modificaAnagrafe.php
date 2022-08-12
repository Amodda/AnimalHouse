<?php 
 session_start();
 $users = $_SESSION["users"];

 $new_name = $_POST["name"];
 $new_lname = $_POST["lname"];
 $new_mail = $_POST["email"];
 $new_user = $_POST["username"];
 $i = $_POST["i"];

 $users[$i]["name"]=$new_name;
 $users[$i]["lastname"]=$new_lname;
 $users[$i]["email"]=$new_mail;
 $users[$i]["username"]=$new_user;

 $_SESSION["users"] = $users;
 $jsonUs = json_encode($users);
 if(file_put_contents("../usersTest.json", $jsonUs)){
     echo "Operazione riuscita!";
 }else{
     echo "Aggiornamento password fallito...";
 }
?>