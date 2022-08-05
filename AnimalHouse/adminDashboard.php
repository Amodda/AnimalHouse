<?php
session_start();

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}
if($_SESSION['user']['type'] != "admin"){
    header('Location: index.php');
}

$jsonData = file_get_contents("users.json");
$_SESSION["users"] = json_decode($jsonData, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/game.css">
    <link rel="stylesheet" href="css/backoffice.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Back Office</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/usersManager.js"> 
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top mb-5 shadow">
        <div class="container-fluid my-1">
          <a class="navbar-brand " href="game.html">AnimalHouse <strong>BackOffice</strong></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
              </li>
    
            </ul>
          </div>
        </div>
    </nav>

    <div class="container" >
        <div class="users">
          <table>
            <thead>
              <title> Elenco Utenti </title>
              <tr>
                  <th> Nome </th>
                  <th> Cognome </th>
                  <th> Email </th>
              </tr>
            </thead>
              
              <tbody id="userTable">
                <?php 
                if(isset($_SESSION["users"])){
                  $tempUs = $_SESSION["users"];
                  for($i=0; $i< count($_SESSION["users"]); $i++){
                    echo "<tr>";
                    echo "<td>".json_encode($tempUs[$i]['name'])."</td>";
                    echo "<td>".json_encode($tempUs[$i]['lastname'])."</td>";
                    echo "<td>".json_encode($tempUs[$i]['email'])."</td>";
                    echo "<td><button type='button' onClick=manage(".$i.")> Apri scheda </button></td>";

                    echo "</tr>";
                  }
                }

                
                ?>
              </tbody>
          </table>
        </div>
        <div class="scheda" class= "hidden">
          <div id="data">
              <div id=>
                
              </div>
              <div>
                
              </div>
          </div>
          <div class='hidden' id="password"> 
                  <form action="adminDashboard.php" method="POST">
                    <div id="oldPwd"> </div>
                    <label for="newPwd">Nuova Password: </label>
                    <input type="text" id="newPwd" name="newPwd" required/>
        
                  </form>

              </div>
        </div>
    </div>
</body>
</html>