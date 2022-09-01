<?php
session_start();
//require_once('database.php');


if (isset($_GET['register'])) {
    $username = $_POST['usernameRegister'];
    $password = $_POST['passwordRegister'];
    $confirmPassword = $_POST['confirmPasswordRegister'];
    $email = $_POST['emailRegister'];
    $name = $_POST['nameRegister'];
    $lastname = $_POST['lastnameRegister'];

    $isUsernameValid = filter_var(
        $username,
        FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^[a-z\d_]{3,20}$/i"
            ]
        ]
    );

    $pwdLenght = mb_strlen($password);
    
    if (empty($username) || empty($password) || empty($confirmPassword) || empty($name) || empty($lastname) || empty($email)) {
        $_SESSION['auth_error'] = 'Compila tutti i campi %s';
        echo $msg;
        header('Location: ../signup.php');
    } elseif (false === $isUsernameValid) {
        $msg = 'Lo username non è valido. Sono ammessi solamente caratteri 
                alfanumerici e l\'underscore. Lunghezza minina 3 caratteri.
                Lunghezza massima 20 caratteri';
                echo $msg;
                header('Location: ../signup.php');
    } elseif ($pwdLenght < 6 || $pwdLenght > 20) {
        $msg = 'Lunghezza minima password 8 caratteri.
                Lunghezza massima 20 caratteri';
                echo $msg;
                header('Location: ../signup.php');
    } elseif ($password != $confirmPassword){
        $msg = 'Passwords are not the same.';
        //echo $msg;
        header('Location: ../signup.php');
    } else {    
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $jsonData = file_get_contents("../users.json");
        $users = json_decode($jsonData, true);
        $newUsers = [];
        $userExists = false;
        for($i = 0; $i <= count($users)-1; $i++){
            if($users[$i]["username"] == $username || $users[$i]['email'] == $email){
                    $userExists = true;
                    $msg = "Username o Email già in uso";
                    header('Location: ../signup.php');
                }
                if($i == count($users)-1 && $userExists == false){
                    $user = [
                        "name" => $name,
                        "lastname" => $lastname,
                        "email" => $email,
                        "username" => $username,
                        "password" => $password_hash,
                        "gamesPoints" => [
                            "quiz" => 0,
                            "hangman" => 0,
                            "memory" => 0
                        ],
                        "type" => "user"
                    ];
                    $newUsers = $users;
                    array_push($newUsers, $user);
                    $json = json_encode($newUsers);
                    //write json to file
                    if (file_put_contents("../users.json", $json)){
                        $_SESSION['auth_success'] = 'Sucessfully signed up';
                        header('Location: ../signin.php');
                    } else {
                        echo "Oops! Error creating json file...";
                    }
                    
                }
        }

    }
    if(isset($msg)){
        $_SESSION['auth_error'] = $msg; 
    }
   
}



if (isset($_GET['login'])) {

    $username = $_POST['usernameLogin'];
    $password = $_POST['passwordLogin'];
    echo $username." ".$password;
    
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $jsonData = file_get_contents("../users.json");
        $users = json_decode($jsonData, true);
        $usrFound = false;
        for($i = 0; $i <= count($users)-1; $i++){
                if($users[$i]["username"] == $username){
                    if(password_verify($password, $users[$i]["password"]) === true){
                        $_SESSION['user'] = [
                            "name" => $users[$i]['name'],
                            "lastname" => $users[$i]['lastname'],
                            "username" => $users[$i]['username'],
                            "email" => $users[$i]['email'],
                            "type" => $users[$i]['type'],
                            "cartItems" => array()
                        ];
                        
                        header('Location: ../index.php');
                    } else {
                        $msg = "Wrong credentials";
                        header('Location: ../signin.php');
                    }
                    $usrFound = true;
                }
                if($i == count($users)-1 && $usrFound == false){
                    $msg = "User not registered";
                    header('Location: ../signin.php');
                }
            
            

        }

    }
    
    //printf($msg, '<a href="../login.html">torna indietro</a>');
    echo $msg;
   $_SESSION['auth_error'] = $msg;
}


if(isset($_GET['logout'])){

    unset($_SESSION['user']);
    header('Location: ../index.php');
}
?>