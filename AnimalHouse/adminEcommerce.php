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

    <?php
      if(isset($_SESSION['success_msg'])){
        echo '<div class="container w-100 d-flex flex-column align-items-center justify-content-center border rounded shadow my-3" id="message">'; 
          echo '<p class="m-1" style="color: green">'.$_SESSION['success_msg'].'</p>';
        echo '</div>';
      }
    ?>

    <div class="container w-100">
            <h2 class="my-2">E-Commerce</h2>
    </div>


    <div class="container w-100  flex-column align-items-center justify-content-center border rounded shadow mt-3" style="display: <?php if(isset($_GET['product'])){ echo 'none';} else { echo 'flex';}?>;" id="productsList">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2" >
            <h4>Products</h4>
            <div style="max-height: 50vh; max-width: 100%; overflow-y: auto; overflow-x: auto;">

            
            <table class="w-100 table table-hover my-3" >
              <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Info</th></tr>
              <?php
              $jsonData = file_get_contents("data/store.json");
              $store = json_decode($jsonData, true);
              $storeCat = $store['categories'];
              $storeTags = $store['tags'];
              $storeProd = $store["products"];

              for($i = 0; $i < count($storeProd); $i++){
                echo '<tr><td>'.$storeProd[$i]['id'].'</td><td>'.$storeProd[$i]['name'].'</td><td>'.$storeProd[$i]['description'].'</td><td>'.$storeProd[$i]['price'].' €</td><td>'.$storeProd[$i]['category'].'</td><td><button class="btn btn-dark" onClick='.'openProductInfo("'.$storeProd[$i]["id"].'")>Info</button></td></tr>';
              }
              //var_dump($store);
              ?>
          </table>
          </div>
          </div>
      </div>
    </div>

    <div class="container w-100 d-flex flex-column align-items-center justify-content-center border rounded shadow my-3"  id="productsList">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2">
            <h4>New Product</h4>
            

            
                <form action="php/backofficeEcommerce.php?newProduct" method="post" class="w-100 d-flex flex-column" enctype="multipart/form-data">
                  <div class="w-100 d-flex flex-row">
                    <div class="w-50 d-flex flex-column align-items-center justify-content-center mt-5">

                                    <!-- Email input -->
                      <div class="w-75 form-outline mb-4">
                          <input type="text"  name="newProductName" class="form-control" placeholder="Name" required/>
                      </div>


                      <!-- Username input -->
                      <div class="w-75 form-outline mb-4">
                        <textarea name="newProductDescription" id="" class="form-control" placeholder="Description" rows="3"></textarea>
                      </div>

                      <div class="w-75 input-group mb-4">
                        
                        <input type="number" class="form-control" min="0" name="newProductPrice" placeholder="Price" aria-label="Price">
                        <span class="input-group-text">€</span>
                      </div>




                    </div>
                    <div class="w-50 d-flex flex-column align-items-center mt-5">
                      <div class="w-50 mb-4">
                        <select class="form-select " name="newProductCategory">
                        <option selected disabled>Category</option>
                        <?php 
                          for($i = 0; $i < count($storeCat); $i++){
                            echo '<option value="'.$storeCat[$i].'" >'.$storeCat[$i].'</option>';
                          }
                        ?>
                        </select>
                      </div>


                      <div class="w-50 mb-4">
                        <select class="form-select " name="newProductTag[]" multiple>
                        <option selected disabled>Tags</option>
                        <?php 
                          for($i = 0; $i < count($storeTags); $i++){
                            echo '<option value="'.$storeTags[$i].'" >'.$storeTags[$i].'</option>';
                          }
                        ?>
                        </select>
                      </div>

                      <div class="d-flex flex-row align-items-center justify-content-center mb-4">
                        <p class="mb-0"><strong>Img: </strong></p>
                        <div class="form-outline w-50 mx-3">
                            
                            <input class="form-control" type="file" name="newProductImg" id="formFile">
                        </div>
                      </div>
                            


                    </div>
                  </div>
                  <div class="d-flex justify-content-center my-5">
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-dark btn-block w-50">Add Product</button>
                  </div>
                  <?php
                  if(isset($_SESSION['auth_error'])){
                      echo $_SESSION['auth_error'];
                  }
                  ?>
                </form>
         
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
<?php
unset($_SESSION['success_msg']);
?>