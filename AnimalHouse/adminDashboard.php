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

$readfile = file_get_contents("favourites.json");
$_SESSION["favList"] =json_decode($readfile, true);

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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/usersManager.js">  </script>
    <title>Back Office</title>
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
              <li class="nav-item">
                <a class="nav-link" href="adminForum.php">Forum</a>
              </li>
    
            </ul>
          </div>
        </div>
    </nav>
    <div class="container">
    
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
                      echo "<td><a onClick=manage(".$i.") class='open bg-dark text-white px-1 py-1 rounded-2' href='#scheda' > Open card </button></td>";

                      echo "</tr>";
                    }
                  }

                  
                  ?>
                </tbody>

            </table>
        </div>    
     
        </div>
        <hr></hr>
        <div id="scheda" class="w-80 d-flex d-none flex-column fadeIn">
          <div class="w-100 d-flex flex-row align-items-center justify-content-center fill-auto mb-3">
            <h2 class="w-100 d-flex flex-column align-items-left " >User Card </h2>
            <img class="w-100 d-flex flex-column align-items-right" src="X_cross.PNG" href="#boxUtenti" id="close" ></img> 
          </div>
          <div id="anagrafe" class="w-100 d-flex flex-row">
            <div class="w-25 d-flex flex-column align-items-left justify-content-left mt-3 ms-3">
              <div class="editable w-100 "> Change Username:
                  <h5 id="username"></h5></div>
                  <div class="w-100 mt-3" style="font-size: 15px;" id="pass"></div>
                  <div class="w-100 d-flex "id="msgErr" style="color: red; font-size: 12px; z-index: 3;"></div>
                  <div class='w-100 ' id="password" style="display: none;">
                  <div class="mt-3">Old password: </div>
                    <input type="password" id="oldPwd" name="oldPwd" class="inp_pwd w-100" required/>
                      <div class="row">
                      <div class='col-md-12'>
                        <div>New Password: </div>
                        <input type="password" id="newPwd" name="newPwd" class="inp_pwd w-100 " required/>
                          <div class="row">
                            <div class='col-md-12'>
                            <div>Confirm Password: </div>
                            <input type="password" id="confnewPwd" name="congnewPwd" class="inp_pwd w-100" required/>
                            <div class="w-100" id="invia"></div>
                          </div>
                          </div>
                      </div>
                      </div>
                  </div> 
            </div>
            <div class="w-25 d-flex flex-column align-items-left justify-content-left mt-3 ms-3">
            <div class="editable w-100"> Change name:
                      <h5 class="text-truncate" id="name"></h5></div>
                <div class="editable w-100 mt-3"> Change lastname:
                      <h5 class="text-truncate" id="lastname"></h5></div>
                <div class="editable w-100 mt-3"> Change email:
                      <h5 class="text-truncate" id="email"></h5></div>
                <div id="cancelUser" class="editable w-70">></div>
            </div>
            <div class="w-25 d-flex flex-column align-items-left justify-content-left mt-3 ms-3">
            <div class="w-100"> Preferences:
                <div class="table-wrapper-scroll-y my-custom-scrollbar-scheda mt-3">
                    <table class="table table-bordered table-striped mb-0" id="favTable">
                        <thead></thead>
                        <tbody id="favBody" >
                    
                        </tbody>
                    </table>
                </div>
                <div class="w-100 mt-3 mb-3" id="choiceFav" style="display: none;">
                  <form action="form">
                    <fieldset id="fieldsetPref" >
                    </fieldset>
                  </form>
                </div>
                  
                </div>
                <div id="modPref" class="w-100 mt-3">
                    <button id="modificaPref" onclick="changePref()"> Change Preferences </button>
                  </div>
            </div>
            <div class="w-25 d-flex flex-column align-items-left justify-content-left mt-3 ms-3"> Game points:
            <div class="editable mt-3 w-100"> Quiz:
                      <h5 id="quiz"></h5>
                    </div>
                    <div class="editable w-100 mt-3"> Hangman:
                      <h5 id="hang"></h5>
                    </div>
                    <div class="editable w-100 mt-3"> Memory:
                      <h5 id="memo"></h5>
                    </div>
            </div>
          </div>
          <div class="w-100 d-flex flex-row align-items-center justify-content-center mt-5" id="finalrow">
              <div class="w-80 d-flex">
                <div id="salva"></div>
              </div>
          </div> 
         
        </div>
        <script type="text/javascript" src="js/edit.js">  </script>
    </div>
   
</body>
</html>-