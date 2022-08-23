<?php
session_start();
if(!isset($_SESSION['user'])){
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/store.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/userCart.js"></script>
    <title>MyCart</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
        <div class="container-fluid">
          <a class="navbar-brand " href="index.php">AnimalHouse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>


              <?php
              
                    if(!isset($_SESSION['user'])){
                        echo '<li class="nav-item ">';
                            echo '<a class="nav-link" href="signin.php">Sign in</a>';
                        echo '</li>';
                    }
                    if(isset($_SESSION['user'])){
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link active" href="store.php">Store</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="forum.php">Forum</a>';
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

    <div class="container d-flex flex-column align-items-center my-3" style="min-height: 100vh;">
        <div class="w-100" id="communityGames">
            <div class="w-100 d-flex justify-content-start mt-5">
                <h1>Your Cart</h1>
            </div>
            <div id="updateResponse" class="d-flex w-100 align-items-center justify-content-center my-4"></div>
            <div class="container w-75 d-flex flex-column justify-content-start mt-4" id="itemsList">
                <?php

                $jsonData = file_get_contents("data/store.json");
                $store = json_decode($jsonData, true);
                $cartValue = $_SESSION['user']['cartItems'];
                $cart = [];

                for($i = 0; $i < count($cartValue); $i++){
                    for($j = 0; $j < count($store['products']); $j++){
                        if($cartValue[$i]['id'] == $store['products'][$j]['id']){
                            array_push($cart, $store['products'][$j]);
                        }
                    }
                }
                //var_dump($cart);

                
                for($i = 0; $i < count($cart); $i++){
                    echo '<div class="w-100 d-flex flex-row my-3" id="'.$cart[$i]['id'].'">';
                        echo '<div class="w-50">';
                        if($cart[$i]['img'] != ""){
                            echo '<img src="'.$cart[$i]['img'].'" style="width: 10vh; height: 10vh;">';
                        } else {
                            echo '<img src="noimage.png" style="width: 10vh; height: 10vh;">';
                        }
                            
                        echo '</div>';
                        echo '<div class="w-100 d-flex flex-column align-items-center justify-content-center">';
                            echo '<h5>'.$cart[$i]['name'].'</h5>';
                        echo '</div>';
                        echo '<div class="w-100 d-flex flex-row align-items-center">';
                            echo '<div class="btn border shadow-sm" style="border-radius: 5em;" onClick='.'removeQty("product'.$i.'")><p class="p-3 my-0">-</p></div>';
                            echo '<p class="mx-3 my-0" id="product'.$i.'">'.$cartValue[$i]['qty'].'</p>';
                            echo '<div class="btn border shadow-sm" style="border-radius: 5em;" onClick='.'addQty("product'.$i.'")><p class="p-3 my-0">+</p></div>';
                        echo '</div>';
                        echo '<div class="w-100 d-flex flex-row align-items-center">';
                            echo '<form action="php/productsManagement.php?removeProduct='.$cartValue[$i]['id'].'" method="post">';
                                echo '<button type="submit" class="btn btn-danger">Remove</button>';
                            echo '</form>';
                        echo '</div>';
                        
                    echo '</div>';
                    
                }

                echo '</div>';
                echo '<hr class="my-3">';
                if(count($cart) > 0){
                        echo '<button type="" class="btn btn-dark" onClick="updateCart()">Update Cart</button>';
                }

                

                

                    /*
                    for($i = 0; $i < count($store['products']);$i++){
                        echo '<div class="container w-100 d-flex flex-row justify-content-start" style="max-width: 100%">';
                            for($j = $i; $j < $i + 3; $j++){
                                if($store['products'][$j] != null){
                                    echo '<div class="w-25 m-3 d-flex flex-column justify-content-center rounded border shadow-sm" id="product'.$j.'">';
                                    echo '<div class="p-4">';
                                        echo '<h4>'.$store['products'][$j]['name'].'</h4>';
                                        echo '<p style="margin: 0; font-size: 18px;">'.$store['products'][$j]['description'].'</p>';
                                    echo '</div>';
                                echo '</div>';
                                }

                            }
                        $i = $i +2;
                        echo '</div>';
                        }
                    
                    */
                    

                ?>
               
        
           
            
            <!--<hr class="my-5" style="opacity: 0.1">-->

        </div>
    </div>
    <div class=" w-100 d-flex flex-column align-items-center justify-content-start bg-dark" id="newPost">

            </div>
    




    <footer class="bg-light text-center w-100" >


        <!-- Copyright -->
        <div class="text-center p-3 ">
          © 2022 Copyright:
          <a class="text-dark" href="">Alessandro Modelli</a>
        </div>
        <!-- Copyright -->
      </footer>

<script>

    

</script>
</body>
</html>

<?php
    unset($_SESSION['error_msg']);
?>