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
    
        $newPostID = count($posts[$category]['items']);
    
        $post = [
            "id" => $newPostID,
            "date" => $date,
            "user" => $_SESSION['user']['username'],
            "title" => $title,
            "text" => $text,
            "img" => ""
        ];
    
        array_push($posts[$category]['items'], $post);
        $json = json_encode($posts);
        //write json to file
        if (file_put_contents("../posts.json", $json)){
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
?>