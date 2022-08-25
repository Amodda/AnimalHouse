<?php
session_start();

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}
if($_SESSION['user']['type'] != "admin"){
    header('Location: index.php');
}

$jsonData = file_get_contents("usersTest.json");
$_SESSION["users"] = json_decode($jsonData, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/backoffice.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Back Office</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/usersManager.js">  </script>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top mb-5 shadow">
        <div class="container-fluid my-1">
          <a class="navbar-brand " href="index.php">AnimalHouse <strong>BackOffice</strong></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link active" href="#">Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="adminEcommerce.php">E-Commerce</a>
              </li>
    
            </ul>
          </div>
        </div>
    </nav>
      <div id="backgroundImg">
          <div class="w-100" style="height: 100vh;background: rgb(0,0,0,0.5);">
          <div style="height:60% ;">
            <h1 id="titleS"> Admin Dashboard </h1>
          </div>
          <div class="w-100 d-flex align-items-center" style="height: 40%;">
            <div class="row" id="headButtons" style="height: 100%;">
              <div class="col-6 col-sm-3">
                <a href="#boxUtenti" class="btnHead"> Manage Users</a>
              </div>
              <div class="col-6 col-sm-3">
                <a href="" class="btnHead">Other Option</a>
              </div>
            </div>
          </div>
      </div>
      </div>
    
    

    <hr class="w-100"> 

    <div class="body">
    
      <div id="boxUtenti">
          <h1 style="text-align: center;"> Users List: </h1>
          <b>Search user:
              <input id="search" type="text" 
                    placeholder="Search">
            </b>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped mb-0" id="userTable">
              <thead>
                <tr>
                    <th> Nome </th>
                    <th> Cognome </th>
                    <th> Email </th>
                </tr>
              </thead>
                
                <tbody id="tableBody" >
                  <?php 
                  if(isset($_SESSION["users"])){
                    $tempUs = $_SESSION["users"];
                    for($i=0; $i< count($_SESSION["users"]); $i++){
                      echo "<tr>";
                      echo "<td>".$tempUs[$i]['name']."</td>";
                      echo "<td>".$tempUs[$i]['lastname']."</td>";
                      echo "<td>".$tempUs[$i]['email']."</td>";
                      echo "<td><button type='button' onClick=manage(".$i.") class='open'> Apri scheda </button></td>";

                      echo "</tr>";
                    }
                  }

                  
                  ?>
                </tbody>

            </table>
        </div>    
     
        </div>
        
        <div id="scheda" style="display:none;">
        <div class="row">
         <h2 class="col-9 col-sm-4"> Scheda Utente </h2>    
         <a href="#boxUtenti" id="close" class="col-3 col-sm-2 offset-md-6">X</a>      
        </div>
        <div class="row">
        <div class="editable col-4 col-sm-2"> Modifica nome:
              <h3 id="name"></h3></div>
        <div class="editable col-4 col-sm-2"> Modifica cognome:
              <h3 id="lastname"></h3></div>
        <div class="editable col-4 col-sm-2"> Modifica email:
              <h3 id="email"></h3></div>

        
        </div>
        <div class="row">
            <div class="editable col-6 col-sm-3"> Username:
              <h3 id="username"></h3></div>
            
            <div class="col-6 col-sm-3" id="salva"></div>
          </div>
        
        <div class="row">
        <div class="col-6 col-sm-3" id="data">
              
        </div>
        </div>
        <div class="row">
          <div class='col' id="password" style="visibility: hidden;"> 
                  <form action="adminDashboard.php" method="POST">
                    <label for="oldPwd">Inserire vecchia password: </label>
                    <input type="text" id="oldPwd" name="oldPwd" required/>
                    <label for="newPwd">Nuova Password: </label>
                    <input type="text" id="newPwd" name="newPwd" required/>
                    
                  </form>

            </div>
          </div>
        </div>
        <script type="text/javascript" src="js/edit.js">  </script>
    </div>
   
</body>
</html>