<?php
session_start();
if(!isset($_SESSION['user'])){
    header('Location: index.php');
}

function showProducts($category) {
    $jsonData = file_get_contents("data/store.json");
    $store = json_decode($jsonData, true);
    $storeProducts = [];
        for($i = 0; $i < count($store['products']);$i++){
            if($store['products'][$i]['category'] == $category){  
                array_push($storeProducts, $store['products'][$i]);
            }
        }

        echo '<p class="container m-3" style="font-size: 18px;">'.count($storeProducts).' products available</p>';
        for($i = 0; $i < count($storeProducts);$i++){
            echo '<div class="container d-flex productsContainer" style="max-width: 100%">';
                for($j = $i; $j < $i + 3; $j++){
                    if($storeProducts[$j] != null){
                        echo '<div class=" m-3 d-flex flex-column justify-content-center rounded border shadow-sm productCard" id="product'.$j.'" onClick='.'location.href="product.php?product='.$storeProducts[$j]['id'].'">';
                        echo '<div class="container w-100 d-flex justify-content-center">';
                            if($storeProducts[$j]['img'] == ""){
                                echo '<img src="noimage.png" class="storeProductImg">';
                            }else{
                                echo '<img src="data/productImg/'.$storeProducts[$j]['id'].'/'.$storeProducts[$j]['img'].'" class="storeProductImg">';
                            }
                            
                        echo '</div>';
                        echo '<div class="m-4">';
                            echo '<h4>'.$storeProducts[$j]['name'].'</h4>';
                            echo '<p style="margin: 0; font-size: 15px;">'.$storeProducts[$j]['description'].'</p>';
                            echo '<div class="container w-100 d-flex align-items-center justify-content-end mt-3" style="font-weight:bold">';
                                echo '<p class="m-0">'.$storeProducts[$j]['price'].' €</p>';
                            echo '</div>';
                        echo '</div>';

                    echo '</div>';
                    }
                }
            $i = $i +2;
            echo '</div>';
            }

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
    <title>AnimalStore</title>
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
                            echo '<a class="nav-link active" href="">Store</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link active" href="userCart.php"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bag" viewBox="0 0 18 18">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                          </svg><span style="font-size: 12px; margin: 0 0 1em 0">'.count($_SESSION['user']['cartItems']).'</span></a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="forum.php">Forum</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="profile.php">Profile</a>';
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
            <div class="w-100 d-flex align-items-center justify-content-start mt-5">
                <h1>Store</h1>
            </div>
            <div class="w-100 d-flex flex-column justify-content-start" >
                <?php
                //var_dump($_SESSION['user']['cartItems']);
                $jsonData = file_get_contents("data/store.json");
                $store = json_decode($jsonData, true);
                $storeProducts = [];

                    echo '<div class="d-flex flex-row align-items-center mt-3" style="overflow: auto; width: 100%;">';
                    
                    if(isset($_GET['category'])){
                        echo '<div class="w-50 d-flex flex-row align-items-center justify-content-center border shadow-sm m-3" style="border-radius: 2em;">';
                    }else {
                        echo '<div class="w-50 d-flex flex-row align-items-center justify-content-center border shadow-sm m-3" style="border-radius: 2em; background: #d9d9d9">';
                    }
                            echo '<a class="w-100 h4 p-3 m-0" style="text-decoration: none; color: black;text-align: center" href="store.php">All</a>';
            
                        echo '</div>';
                    for($i = 0; $i < count($store["categories"]); $i++){
                        if($store["categories"][$i] == $_GET['category']){
                            echo '<div class="w-75 d-flex flex-row align-items-center justify-content-center border shadow-sm m-3" style="border-radius: 2em; background: #d9d9d9">';
                        }else{
                            echo '<div class="w-75 d-flex flex-row align-items-center justify-content-center border shadow-sm m-3" style="border-radius: 2em;">';
                        }
                        
                            echo '<a class="w-100 h4 p-3 m-0" style="text-decoration: none; color: black;text-align: center" href="store.php?category='.$store["categories"][$i].'">'.$store["categories"][$i].'</a>';
                
                        echo '</div>';
                    }
                    echo '</div>';

                    echo '<hr class="my-3">';
                    if(isset($_GET['category'])){
                        showProducts($_GET['category']);
                    } else {
                        echo '<p class="container m-3" style="font-size: 18px;">'.count($store['products']).' products available</p>';
                        for($i = 0; $i < count($store['products']);$i++){
                            echo '<div class="container d-flex productsContainer" style="max-width: 100%">';
                                for($j = $i; $j < $i + 3; $j++){
                                    if($store['products'][$j] != null){
                                        echo '<div class=" m-3 d-flex flex-column justify-content-center rounded border shadow-sm productCard" id="product'.$j.'" onClick='.'location.href="product.php?product='.$store['products'][$j]['id'].'">';
                                        echo '<div class="container w-100 d-flex justify-content-center">';
                                            if($store['products'][$j]['img'] == ""){
                                                echo '<img src="noimage.png" class="storeProductImg">';
                                            }else{
                                                echo '<img src="data/productImg/'.$store['products'][$j]['id'].'/'.$store['products'][$j]['img'].'" class="storeProductImg">';
                                            }
                                            
                                        echo '</div>';
                                        echo '<div class="m-4">';
                                            echo '<h4>'.$store['products'][$j]['name'].'</h4>';
                                            echo '<p style="margin: 0; font-size: 15px;">'.$store['products'][$j]['description'].'</p>';
                                            echo '<div class="container w-100 d-flex align-items-center justify-content-end mt-3" style="font-weight:bold">';
                                                echo '<p class="m-0">'.$store['products'][$j]['price'].' €</p>';
                                            echo '</div>';
                                        echo '</div>';
                
                                    echo '</div>';
                                    }
                                }
                            $i = $i +2;
                            echo '</div>';
                            }
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
               
        
            
            </div>
            <!--<hr class="my-5" style="opacity: 0.1">-->

        </div>
    </div>

    


<hr class="m-0 mt-5">
<footer class="text-center text-lg-start bg-light text-muted">

<!-- Section: Social media -->

<!-- Section: Links  -->
<section class="">
  <div class="container text-center text-md-start pt-4">
    <!-- Grid row -->
    <div class="row mt-3">
      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
        <!-- Content -->
        <h6 class="text-uppercase fw-bold mb-4">
          <i class="fas fa-gem me-3"></i>AnimalHouse
        </h6>
        <p>
          We are a leader company in the pet products and services field. Feel free to take a look around!
        </p>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
        <!-- Links -->
        <h6 class="text-uppercase fw-bold mb-4">
          Services
        </h6>
        <p>
          <a href="#gamesList" class="text-reset">Games</a>
        </p>
        <p>
          <a href="#ecommerce" class="text-reset">E-Commerce</a>
        </p>
        <p>
          <a href="#forum" class="text-reset">Forum</a>
        </p>
      </div>


      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
        <!-- Links -->
        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
        <p><i class="fas fa-home me-3"></i> Bologna, IT</p>
        <p>
          <i class="fas fa-envelope me-3"></i>
          email
        </p>
        <p><i class="fas fa-phone me-3"></i> Mobile</p>
       
      </div>
      <!-- Grid column -->
    </div>
    <!-- Grid row -->
  </div>
</section>
<!-- Section: Links  -->

<!-- Copyright -->
<div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.05);">
  © 2021 Copyright:
  
</div>
<!-- Copyright -->
</footer>

<script>
    function openProductDetails(id){
        location.href = "store.php?product=" + id;
    }
</script>
</body>
</html>

<?php
    unset($_SESSION['error_msg']);
?>