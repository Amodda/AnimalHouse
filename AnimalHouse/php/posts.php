<?php
session_start();

if(isset($_GET['createPost'])){
    $title = $_POST['postTitle'];
    $text = $_POST['postText'];
    $category = $_POST['postCategory'];
    $date = date("Y-m-d");

    if($title == "" || $text == "" || $category == ""){
        $msg = "Missing fields";
        header('Location: ../forum.php#newPost');
    } else {
        $jsonData = file_get_contents("../posts.json");
        $posts = json_decode($jsonData, true);
    
        $newPostID = uniqid();//count($posts[$category]['items']);
        
        //IMG CHECKS
        if(is_uploaded_file($_FILES['postImg']['tmp_name'])){
            $target_dir = '../posts/'.$category.'_'.$newPostID.'/';
            $target_file = $target_dir . basename($_FILES["postImg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["postImg"]["tmp_name"]);
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
        
            /*
            // Check file size
            if ($_FILES["postImg"]["size"] > 500000) {
                $msg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }*/
            

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $msg = "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
        }


        
        $post = [
            "id" => $newPostID,
            "date" => $date,
            "user" => $_SESSION['user']['username'],
            "title" => $title,
            "text" => $text,
            "img" => $_FILES["postImg"]["name"] ?? ""
        ];
    
        

        array_push($posts[$category]['items'], $post);
        $json = json_encode($posts);
        //write json to file

        if (file_put_contents("../posts.json", $json)){
            if($uploadOk == 1){
                mkdir($target_dir);
                if (move_uploaded_file($_FILES["postImg"]["tmp_name"], $target_file)) {
                    //success
                } else {
                    $msg = 'There was an error uploading the image.';
                }
            }
            $_SESSION['success_msg'] = 'Post successfully created';
            header('Location: ../forum.php');


        } else {
            echo "Oops! Error creating json file...";
    
        }
    }

    if(isset($msg)){
        $_SESSION['error_msg'] = $msg;
    }

}

if(isset($_GET['deletePost'])){
    $postId = $_GET['post'];
    $postCategory = $_GET['category'];

    
    $jsonData = file_get_contents("../posts.json");
    $posts = json_decode($jsonData, true);

    //$posts = $posts[$postCategory];

    var_dump($posts);
    
    for($i = 0; $i < count($posts[$postCategory]['items']); $i++){
        if($posts[$postCategory]['items'][$i]['id'] == $postId){
            array_splice($posts[$postCategory]['items'], $i, 1);

            $json = json_encode($posts);
            //write json to file
            if (file_put_contents("../posts.json", $json)){
                $postImg = "../posts/".$postCategory."_".$postId."/";
                rmrf($postImg);
                break;
            }



        }
    }
    echo '<br><br>';
    var_dump($posts);
    
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