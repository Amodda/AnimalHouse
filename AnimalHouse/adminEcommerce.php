<?php
session_start();

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}
if($_SESSION['user']['type'] != "admin"){
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
    <link rel="stylesheet" href="css/backoffice.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Back Office</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/adminEcommerce.js">  </script>
    
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
                <a class="nav-link" href="adminDashboard.php">Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="adminEcommerce.php">E-Commerce</a>
              </li>
    
            </ul>
          </div>
        </div>
    </nav>

    <div class="container w-100">
            <h2 class="my-2">E-Commerce</h2>
    </div>

    <div class="container w-100  flex-column align-items-center justify-content-center border rounded shadow mt-3" style="display: <?php if(isset($_GET['product'])){ echo 'none';} else { echo 'flex';}?>;" id="productsList">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2">
            <h4>Products</h4>
            <table class="w-100 table table-hover my-3">
              <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Info</th></tr>
              <?php
              $jsonData = file_get_contents("data/store.json");
              $store = json_decode($jsonData, true);
              $store = $store["products"];

              for($i = 0; $i < count($store); $i++){
                echo '<tr><td>'.$store[$i]['id'].'</td><td>'.$store[$i]['name'].'</td><td>'.$store[$i]['description'].'</td><td>'.$store[$i]['price'].' €</td><td>'.$store[$i]['category'].'</td><td><button class="btn btn-dark" onClick='.'openProductInfo("'.$store[$i]["id"].'")>Info</button></td></tr>';
              }
              //var_dump($store);
              ?>
          </table>
          </div>
      </div>
    </div>

    <div class="container w-100  flex-column align-items-center justify-content-center border rounded shadow mt-3" style="display: <?php if(isset($_GET['product'])){ echo 'flex';} else { echo 'none';}?>;" id="productInfo">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2">
            <h4>Product Info</h4>
            <?php
              $productID = $_GET['product'];
              for($i = 0; $i < count($store); $i++){
                if($store[$i]['id'] == $productID){
                  $productInfo = $store[$i];
                  break;
                }
              }

              var_dump($productInfo);
            ?>
          </div>
      </div>
    </div>



    <!--
      <div class="w-100" style="height: 100vh; background: rgb(0,0,0,0.5)">
          <div style="height:40% ;">
            <h1 id="titleS"> Admin Dashboard </h1>
          </div>
          <div class="w-100 d-flex align-items-center" style="height: 60%;">
            <div class="row" id="headButtons">
              <div class="col-6 col-sm-3">
                <a href="#users" class="btnHead"> Manage Users</a>
              </div>
              <div class="col-6 col-sm-3">
                <a href="" class="btnHead">Other Option</a>
              </div>
            </div>
          </div>
      </div>
    

    <hr class="w-100"> 
-->



   <script>
    function openProductInfo(product){
      location.href = "adminEcommerce.php?product=" + product;
    }
   </script>
</body>
</html>