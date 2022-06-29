<?php
session_start();
//require_once('database.php');


if (isset($_GET['register'])) {
    $username = $_POST['usernameRegister'];
    $password = $_POST['passwordRegister'];
    $confirmPassword = $_POST['confirmPasswordRegister'];
    $name = $_POST['nameRegister'];
    $lastname = $_POST['lastnameRegister'];
    $birthDate = $_POST['birthDateRegister'];
    $place = $_POST['placeRegister'];

    $isUsernameValid = filter_var(
        $username,
        FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^[a-z\d_]{3,20}$/i"
            ]
        ]
    );

    $pwdLenght = mb_strlen($password);
    
    if (empty($username) || empty($password) || empty($confirmPassword) || empty($name) || empty($lastname) || empty($birthDate) || empty($place)) {
        $_SESSION['auth_error'] = 'Compila tutti i campi %s';
        echo $msg;
        header('Location: ../index.php');
    } elseif (false === $isUsernameValid) {
        $msg = 'Lo username non è valido. Sono ammessi solamente caratteri 
                alfanumerici e l\'underscore. Lunghezza minina 3 caratteri.
                Lunghezza massima 20 caratteri';
                echo $msg;
                header('Location: ../index.php');
    } elseif ($pwdLenght < 6 || $pwdLenght > 20) {
        $msg = 'Lunghezza minima password 8 caratteri.
                Lunghezza massima 20 caratteri';
                echo $msg;
                header('Location: ../index.php');
    } elseif ($password != $confirmPassword){
        $msg = 'Passwords are not the same.';
        //echo $msg;
        header('Location: ../index.php');
    } else {    
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "select Username from Utente where Username = :username";

        $res = $pdo -> prepare($sql);
        $res -> bindParam(':username', $username, PDO::PARAM_STR);
        $res -> execute();
        $rowCount = $res->rowCount();
        $res -> closeCursor();
        
        if ($rowCount > 0) {
            $msg = 'Username già in uso %s';
            header('Location: ../index.php');
            //echo $msg;
        } else {
            $sql1 = 'call registrazioneUtente(:username,:password_hash,:name,:lastname,:birthDate,:place);';
            //$res -> bindParam(':username', $username, PDO::PARAM_STR);
            $res = $pdo -> prepare($sql1);
            $res -> execute(array(
                ':username' => $username,
                ':password_hash' => $password_hash,
                ':name' => $name,
                ':lastname' => $lastname,
                ':birthDate' => $birthDate,
                ':place' => $place

            ));
            $rowCount1 = $res->rowCount();
            $res -> closeCursor();

            if ($rowCount1 > 0) {
                $_SESSION['auth_success'] = 'Registrazione eseguita con successo';
                
                $doc = ([
                    'ActionDate' => $date = date('Y-m-d H:i:s'),
                    'ActionType' => 'New user',
                    'ActionDetails' => 'User '.$username.' registered to the platform',
                    ]);
                    
                $bulk -> insert($doc);
                $resultMongoDB = $manager -> executeBulkWrite($db,$bulk);
                
                header('Location: ../index.php#authentication');
            } else {
                $msg = 'Problemi con l\'inserimento dei dati %s';
                header('Location: ../index.php');
                
            }
        }
    }
    if(isset($msg)){
        $_SESSION['auth_error'] = $msg; 
    }
    
   
}

/*
if (isset($_GET['login'])) {
    $username = $_POST['usernameLogin'];
    $password = $_POST['passwordLogin'];
    
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $sql = 'call loginUtente("'.$username.'")';
        $result = $conn -> query($sql);

        if($result -> num_rows > 0){
            $result = $result -> fetch_assoc();
        } else {
            $_SESSION['auth_error'] = 'Credenziali utente errate';
            header('Location: ../index.php');
        }
        
        
        if ($result['Username'] == '' || password_verify($password, $result['Password']) === false) {
            $msg = 'Credenziali utente errate';
            header('Location: ../index.php');

        } else {
            //session_regenerate_id();
           // $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $result['Username'];
            $_SESSION['session_userType'] = $result['Tipo'];

            header('Location: ../index.php');
            //exit;
        }
    }
    
    //printf($msg, '<a href="../login.html">torna indietro</a>');
    $_SESSION['auth_error'] = $msg;
}
*/

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
                    if($users[$i]["password"] == $password){
                        $msg =  "Logged in";
                        header('Location: ../signin.php');
                    } else {
                        $msg = "Wrong credentials";
                        header('Location: ../signin.php');
                    }
                    $userFound = true;
                } else if($i == count($users)-1 && $usrFound == false){
                    $msg = "User not registered";
                    header('Location: ../signin.php');
                }
            
            

        }

        /*$rowCount = $res->rowCount();

        if($rowCount > 0){
            $result = $res -> fetch();
        } else {
            $_SESSION['auth_error'] = 'Credenziali utente errate';
            header('Location: ../index.php');
        }
        
        
        if ($result['Username'] == '' || password_verify($password, $result['Password']) === false) {
            $msg = 'Credenziali utente errate';
            header('Location: ../index.php');

        } else {

            $_SESSION['session_user'] = $result['Username'];
            $_SESSION['session_userType'] = $result['Tipo'];

            header('Location: ../index.php');
            //exit;
        }
        */
    }
    
    //printf($msg, '<a href="../login.html">torna indietro</a>');
   $_SESSION['auth_error'] = $msg;
}


if(isset($_GET['logout'])){

    unset($_SESSION['session_user']);
    header('Location: ../index.php');
}
?>