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
    <title>Back Office Forum</title>
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
                <a class="nav-link" href="adminEcommerce.php">E-Commerce</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="adminForum.php">Forum</a>
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
            <h2 class="my-2">Forum</h2>
    </div>


    <div class="container w-100  flex-column align-items-center justify-content-center border rounded shadow mt-3" style="display: <?php if(isset($_GET['post'])){ echo 'none';} else { echo 'flex';}?>;" id="productsList">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2" >
            <h4>Posts</h4>
            <div style="max-height: 50vh; max-width: 100%; overflow-y: auto; overflow-x: auto;">

            
            <table class="w-100 table table-hover my-3" >
              <tr><th>Category</th><th>Date</th><th>Title</th><th>Text</th><th>User</th><th>Info</th></tr>
              <?php
              $jsonData = file_get_contents("posts.json");
              $posts = json_decode($jsonData, true);

              for($category = 0; $category < count($posts); $category++){
                for($i = 0; $i < count($posts[$category]['items']); $i++){
                  echo '<tr><td>'.$posts[$category]['category'].'</td><td>'.$posts[$category]['items'][$i]['date'].'</td><td>'.$posts[$category]['items'][$i]['title'].'</td><td>'.substr($posts[$category]['items'][$i]['text'], 0, 50).'...</td><td>'.$posts[$category]['items'][$i]['user'].'</td><td><button class="btn btn-dark" onClick='.'openPostInfo("'.$posts[$category]['items'][$i]["id"].'","'.$category.'")>Info</button></td></tr>'; //<td><button class="btn btn-danger" onClick='.'deletePost("'.$storeProd[$i]["id"].'")>Delete</button></td>
                }
                
              }

              //var_dump($store);
              ?>
          </table>
          </div>
          </div>
      </div>
    </div>



    <div class="container w-100  flex-column align-items-center justify-content-center border rounded shadow my-3" style="display: <?php if(isset($_GET['post'])){ echo 'flex';} else { echo 'none';}?>;" id="postInfo">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-3">
          <div class="w-100 d-flex flex-column my-2">
            <h4>Post Info</h4>
            <?php
              $postId = $_GET['post'];
              $postCategory = $_GET['category'];

              $postInfo = $posts[$postCategory];

              //var_dump($postInfo);
              
              for($i = 0; $i < count($postInfo['items']); $i++){
                if($postInfo['items'][$i]['id'] == $postId){
                  $postInfo = $postInfo['items'][$i];
                  break;
                }
              }

              

              //var_dump($postInfo);
              echo '<div class="w-100 d-flex  justify-content-between mt-3" style="flex-direction: row;" id="postInfoCard">';

                echo '<div class="w-100 d-flex flex-column">';
                  echo '<div class="w-100 d-flex flex-row align-items-center justify-content-start">';
                    echo '<p><strong>Date:</strong></p> <p style="margin-left: 1em">'.$postInfo['date'].'</p>';
                  echo '</div>';
                  echo '<div class="w-100 d-flex flex-row align-items-center justify-content-start">';
                    echo '<p><strong>Title:</strong></p> <p style="margin-left: 1em">'.$postInfo['title'].'</p>';
                  echo '</div>';
                  echo '<div class="w-100 d-flex flex-row align-items-center justify-content-start">';
                    echo '<p><strong>Text:</strong></p> <p style="margin-left: 1em">'.$postInfo['text'].'</p>';
                  echo '</div>';  
                  echo '<div class="w-100 d-flex flex-row align-items-center justify-content-start">';
                    echo '<p><strong>User:</strong></p> <p style="margin-left: 1em">'.$postInfo['user'].'</p>';
                  echo '</div>';  
                echo '</div>';
                
                echo '<div class="w-100 d-flex flex-column  justify-content-center">';
                  echo '<img src="posts/'.$postCategory.'_'.$postId.'/'.$postInfo['img'].'" style="width: 200px; height: 200px;">';
                echo '</div>';
              echo '</div>';

              echo '<form action="php/posts.php?deletePost&&post='.$postId.'&&category='.$postCategory.'" method="post">';
                echo '<div class="w-100 d-flex justify-content-end align-items-center">';
                  echo '<button type="submit" class="btn btn-danger">Delete</button>';
                echo '</div>';
              echo '</form>';

            
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
    function openPostInfo(post, category){
      location.href = "adminForum.php?post=" + post + "&&category=" + category;
    }
   </script>
</body>
</html>
<?php
unset($_SESSION['success_msg']);
?>