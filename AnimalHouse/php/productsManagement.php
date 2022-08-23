<?php
session_start();

if(isset($_GET['addToCart'])){
    $productID = $_GET['addToCart'];

    if(count($_SESSION['user']['cartItems']) == 0){
        $product = [
            "id" => $_GET['addToCart'],
            "qty" => 1
        ];
        array_push($_SESSION['user']['cartItems'], $product);
    } else {
        for($i = 0; $i < count($_SESSION['user']['cartItems']); $i++){
        
            if($productID == $_SESSION['user']['cartItems'][$i]['id']){
                $_SESSION['user']['cartItems'][$i]['qty'] += 1;
            } else {
                $product = [
                    "id" => $_GET['addToCart'],
                    "qty" => 1
                ];
                array_push($_SESSION['user']['cartItems'], $product);
                break;
            }
            
        }
    }

    
    //var_dump($_SESSION['user']['cartItems']);
    header('Location: ../store.php');
}

if(isset($_GET['removeProduct'])){
    $productID = $_GET['removeProduct'];

    for($i = 0; $i < count($_SESSION['user']['cartItems']); $i++){
        
        if($productID == $_SESSION['user']['cartItems'][$i]['id']){
            array_splice($_SESSION['user']['cartItems'], $i);
            break;
        }
        
    }

    header('Location: ../userCart.php');
}

if(isset($_GET['updateCart'])){
    $productsN = $_GET['productsNumber'];
    $products = [];
    for($i = 0; $i < $productsN; $i++){
        $product = [
            "id" => $_GET['product'.$i],
            "qty" => $_GET['qty'.$i]
        ];
        array_push($products, $product);
    }
    if(count($_SESSION['user']['cartItems']) == $productsN){
        //var_dump($products);
        for($i = 0; $i < $productsN; $i++){
            $_SESSION['user']['cartItems'][$i] = $products[$i];
        }
        
    }

    //var_dump($_SESSION['user']['cartItems']);
    echo '<h4 style="color: green">Cart successfully updated</h4>';
    
}
?>