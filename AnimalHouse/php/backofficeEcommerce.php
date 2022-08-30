<?php
session_start();

if(isset($_GET['newProduct'])){
    $productId = uniqid();
    $productName = $_POST['newProductName'];
    $productDescription = $_POST['newProductDescription'];
    $productPrice = $_POST['newProductPrice'];
    $productCategory = $_POST['newProductCategory'];
    
    if(isset($_POST["newProductTag"])){
        $productTags = [];
        // Retrieving each selected option
        foreach ($_POST['newProductTag'] as $tag){
            array_push($productTags, $tag);
        }
           
    }

    $jsonData = file_get_contents("../data/store.json");
    $store = json_decode($jsonData, true);
    /*
    var_dump($store['products']);
    echo "</br></br>";

    var_dump($product);
    echo "</br></br>";

    //array_push($store['products'], $product);

    var_dump($store['products']);
    */
    if(is_uploaded_file($_FILES['newProductImg']['tmp_name'])){
        $target_dir = "../data/productImg/".$productId."/";
        $target_file = $target_dir . basename($_FILES["newProductImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        if($productName == '' || $productDescription == '' || $productPrice == '' || $productCategory == '' || $productTags == ''){
            $msg = "Missing fields.";
            $uploadOk = 0;
        }
    
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["newProductImg"]["tmp_name"]);
            if($check !== false) {
              $uploadOk = 1;
            } else {
              $msg = "File is not an image.";
              $uploadOk = 0;
            }
          }
          
         // Check if folder already exists
         if (file_exists($target_dir)) {
              rmrf($target_dir);
          }
      
          // Check if file already exists
          if (file_exists($target_file)) {
              $msg = "Sorry, file already exists.";
            $uploadOk = 0;
          }
          
          // Check file size
          if ($_FILES["newProductImg"]["size"] > 500000) {
              $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
          }
          
          // Allow certain file formats
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $msg = "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
          }

                
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
        header('Location: ../adminEcommerce.php');
      // if everything is ok, try to upload file
      } else {
        $product = [
            "id" => $productId,
            "name" => $productName,
            "description" => $productDescription,
            "price" => $productPrice,
            "img" => $_FILES["newProductImg"]["name"],
            "category" => $productCategory,
            "tags" => $productTags
        ];
              mkdir($target_dir);
              if (move_uploaded_file($_FILES["newProductImg"]["tmp_name"], $target_file)) {
                array_push($store['products'], $product);
                $json = json_encode($store);

                //write json to file
                if (file_put_contents("../data/store.json", $json)){
                    $_SESSION['success_msg'] = 'Product successfully created';
                    header('Location: ../adminEcommerce.php');
                } else {
                    $_SESSION['error_msg'] = 'There was an error with the request';
                    header('Location: ../adminEcommerce.php');
                }
                  //$_SESSION['success_msg'] = "Conference successfully created";
                //echo "ciao";

                  //header('Location: ../adminConferences.php');
                  //echo "The file ". htmlspecialchars( basename( $_FILES["userPicture"]["name"])). " has been uploaded.";
                } else {
                  echo $msg = "Sorry, there was an error uploading your file.";

                
                  header('Location: ../adminEcommerce.php');
                }

  
      }
    }
}

function rmrf($dir) {
    foreach (glob($dir) as $file) {
        if (is_dir($file)) { 
            rmrf("$file/*");
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

?>