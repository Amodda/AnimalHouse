<?php
session_start();

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}

$jsonData = file_get_contents("usersTest.json");
$users = json_decode($jsonData, true);
for($i = 0; $i <= count($users)-1; $i++){
    if($users[$i]["username"] == $_SESSION["user"]["username"]){
        $gamePoint = [ "quiz" => $users[$i]["gamesPoints"]["quiz"],
                        "hangman" => $users[$i]["gamesPoints"]["hangman"],
                        "memory"  => $users[$i]["gamesPoints"]["memory"]];
    }
}

$readfile = file_get_contents("favourites.json");
$favList =json_decode($readfile, true);
for($i = 0; $i <= count($favList)-1; $i++){
    if($_SESSION["user"]["username"] == $favList[$i]["username"]){
        $_SESSION["favList"] = $favList[$i]["preferences"];
    }
}

// creare sezione di aggiunta animali preferiti
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/animalHouse.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/profileManager.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
        <div class="container-fluid ">
          <a class="navbar-brand " href="index.php">AnimalHouse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

              <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
              </li>
              <?php
                    if(!isset($_SESSION['user'])){
                        echo '<li class="nav-item ">';
                            echo '<a class="nav-link" href="signin.php">Sign in</a>';
                        echo '</li>';

                    }
                    if(isset($_SESSION['user'])){
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="store.php">Store</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="forum.php">Forum</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="#">Profile</a>';
                        echo '</li>';
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome '.$_SESSION['user']['name'].'</a>';
                        echo '<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">';
                        echo '<li><a class="dropdown-item" href="php/authentication.php?logout">Logout</a></li>';
                        if($_SESSION['user']['type'] == "admin"){
                            echo '<li><a class="dropdown-item" href="adminDashboard.php">Admin Panel</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                ?>
            </ul>
          </div>
        </div>
    </nav>
    <div class="container">
        <div class="row" id="name">
            <div class="col-lg-12 col-sm-6"></div>
            <h1><?php echo $_SESSION['user']['name']." ". $_SESSION['user']['lastname']?></h1>
            <h3 id="user"><?php echo $_SESSION['user']['username']?></h3>
        </div>
        <div class="row gap-1">
            <div class="col-md-3 col-sm-2 box">
                <h3>Information: </h3>
                <div class="row">
                    <div class="col"> Name: <b><?php echo $_SESSION['user']['name']; ?> </b></div>
                </div>
                <div class="row">
                    <div class="col"> Lastname: <b><?php echo $_SESSION['user']['lastname']; ?> </b></div>
                </div>
                <div class="row">
                    <div class="col"> Username: <b><?php echo $_SESSION['user']['username']; ?> </b></div>
                </div>
                <div class="row">
                    <div class="col"> E-mail: <b><?php echo $_SESSION['user']['email']; ?> </b></div>
                </div>
            </div>
            <div class="col-md-5 col-sm-2 box">
                <h3>Animals list: </h3>
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table table-bordered table-striped mb-0" id="favTable">
                        <thead>

                        </thead>
                        <tbody id="tableBody" >
                        <?php 
                            if(isset($_SESSION['favList'])){
                                $temp = $_SESSION['favList'];
                                for($i=0; $i< count($_SESSION['favList']); $i++){
                                echo "<tr>";
                                echo '<td class="rowanimal">'.$temp[$i].'</td>';
                                echo '<td><a href="#" class="remove" onClick="deletePref()"> [-] </td>';

                                echo "</tr>";
                                }
                            }

                            
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><a href="#" id="add">Add animals: </a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-3 col-sm-2 box">
                <h3>Games</h3>
                <div class="row text-align-center">
                    <div class="col">Quiz score: <b><?php echo $gamePoint["quiz"]?></b></div>
                </div> 
                <div class="row">
                    <div class="col">Hangman score: <b><?php echo $gamePoint["hangman"]?></b></div>
                </div> 
                <div class="row">
                    <div class="col">Memory score: <b><?php echo $gamePoint["memory"]?></b></div>
                </div>
                <div class="row">
                    <div class="col">Total score: <b>
                        <?php 
                            echo $gamePoint["quiz"]+$gamePoint["hangman"]+$gamePoint["memory"]?></b></div>
                </div>
            </div>
        </div>
        
        
        
    </div>
    <hr>
    <div id="sezP" style="display: none;">
        <h2> Scegli i tuoi animali preferiti: </h2>
        <section class="grid" id="animals"></section>
        <button id="salva_pref" onclick="save()"> Salva Preferiti</button>         
    </div>
    
    

</body>

</html>