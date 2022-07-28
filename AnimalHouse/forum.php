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
    <link rel="stylesheet" href="css/forum.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Forum</title>
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
                            echo '<a class="nav-link" href="store.php">Store</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link active" href="">Forum</a>';
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
                <h4>Welcome to the Community Forum</h4>
            </div>
            <div class="w-100 d-flex flex-column  justify-content-start m-3" id="postsList">
                <?php
                    $jsonData = file_get_contents("posts.json");
                    $posts = json_decode($jsonData, true);
                    /*
                    for($i = 0; $i < count($posts); $i++){
                        echo '<div class=" postCard shadow border">';
                            echo '<div class="m-4 mb-0">';
                                echo '<div class="d-flex align-items-center justify-content-start">';
                                    echo '<h4>'.$posts[$i]['title'].'</h4>';
                                    
                                echo '</div>';

                                echo '<div>';
                                    echo '<p>'.$posts[$i]['text'].'</p>';
                                echo '</div>';
                                echo '<div class="d-flex align-items-center justify-content-end w-100">';
                                    echo '<p style="font-size: 12px">posted by '.$posts[$i]['user']." on ".$posts[$i]['date'].'</p>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                    */
                    $bgColor = ["#f3f5cb","#ecffad","#d1ffad","#dafad2"];
                    

                    
                    if(!isset($_GET['category'])){
                        //Mostra categorie
                        echo '<div class="container">This is where you can find different stories about your favourite animals. Feel free to share some too!</div>';
                            echo '<div class="w-100 d-flex" id="forumContainer">';
                                echo '<div class="w-100 d-flex flex-column align-items-center mt-5">';
                                    for($i = 0; $i < count($posts); $i++){
                                        echo '<div class="w-75 d-flex flex-row align-items-center justify-content-center border rounded shadow-sm m-1" style="background: '.$bgColor[$i].'">';

                                            echo '<a class="w-100 h4 p-3" style="text-decoration: none; color: black;text-align: center" href="forum.php?category='.$posts[$i]['id'].'">'.$posts[$i]['category'].'</a>';
                                    
                                        echo '</div>';
                                    }
                                    echo '<div class="w-50 d-flex flex-row align-items-center justify-content-center border rounded shadow-sm m-3">';
                                        echo '<a class="w-100 h4 p-3" style="text-decoration: none; color: black;text-align: center" href="forum.php?category=all">See all</a>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<div class=" d-flex flex-column  justify-content-center mt-5" id="shareStory">';
                                    echo '<img src="parrot.jpg" class="rounded-circle" style="border-radius: 1em;">';
                                    echo '<h4 class="mt-3">'."I'm sure you have some interesting stories...".'</h3>';
                                    echo '<div class="w-100 d-flex justify-content-center">';
                                    echo '<a class="btn shadow-sm border" style=" font-size: 30px; text-decoration: none; color: black;" href="#newPost">Share it now!</a>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    } else if($_GET['category'] == 'all'){
                        //Mostra post di tutte le categorie
                        echo '<h5>All Animals</h5>';
                        echo '<div class="w-100 d-flex flex-column mt-4">';
                        for($i = 0; $i < count($posts); $i++){
                            for($j = 0; $j < count($posts[$i]['items']); $j++){
                            $rand_background = $bgColor[array_rand($bgColor)];
                            echo '<div class=" postCard shadow border" id="post'.$i."_".$j.'" style="background: '.$rand_background.'">';
                                echo '<div class="m-4 mb-0">';
                                    echo '<div class="d-flex flex-row align-items-center justify-content-between">';
                                        echo '<h4>'.$posts[$i]['items'][$j]['title'].'</h4>';
                                        echo '<h5>'.$posts[$i]['category'].'</h5>';
                                    echo '</div>';
    
                                    echo '<div>';
                                        echo '<p>'.$posts[$i]['items'][$j]['text'].'</p>';
                                    echo '</div>';
                                    echo '<div class="d-flex align-items-center justify-content-end w-100">';
                                        echo '<p style="font-size: 12px">posted by '.$posts[$i]['items'][$j]['user']." on ".$posts[$i]['items'][$j]['date'].'</p>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            }
                        }
                        echo '</div>';
                        echo '<div class="w-100 d-flex align-items-center justify-content-end">';
                            echo '<a class="btn btn-dark m-4" href="forum.php">Back</a>';
                        echo '</div>';
                    } else {
                        //Mostra post della categoria selezionata
                        $category = $_GET['category'];
                        echo '<h5>'.$posts[$category]['category'].'</h5>';
                        if(count($posts[$category]['items']) > 0){
                            echo '<div class="w-100 d-flex flex-column mt-4">';
                            for($i = 0; $i < count($posts[$category]['items']); $i++){
                                $rand_background = $bgColor[array_rand($bgColor)];
                                echo '<div class=" postCard shadow border" id="post'.$i.'" style="background: '.$rand_background.'">';
                                    echo '<div class="m-4 mb-0">';
                                        echo '<div class="d-flex align-items-center justify-content-start">';
                                            echo '<h4>'.$posts[$category]['items'][$i]['title'].'</h4>';
                                            
                                        echo '</div>';
        
                                        echo '<div>';
                                            echo '<p>'.$posts[$category]['items'][$i]['text'].'</p>';
                                        echo '</div>';
                                        echo '<div class="d-flex align-items-center justify-content-end w-100">';
                                            echo '<p style="font-size: 12px">posted by '.$posts[$category]['items'][$i]['user']." on ".$posts[$category]['items'][$i]['date'].'</p>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="w-100 d-flex flex-column mt-4">';
                                echo '<h3 style="opacity: 0.4">Sorry! It looks like there are no posts under this category.</h3>';
                            echo '</div>';
                        }
 
                        echo '<div class="w-100 d-flex align-items-center justify-content-end">';
                            echo '<a class="btn btn-dark m-4" href="forum.php">Back</a>';
                        echo '</div>';
                    }

                ?>
               
        
            
            </div>
            <!--<hr class="my-5" style="opacity: 0.1">-->

        </div>
    </div>
    <div class=" w-100 d-flex flex-column align-items-center justify-content-start bg-dark" id="newPost">
                    <h4 class="text-white mt-5">New post</h4>
                    <div class="container my-4" id="newPostDiv">
                        <form action="php/posts.php?createPost" method="post" enctype="multipart/form-data">
                        

                        
                                <div class="form-outline mb-4 shadow-sm">
                                    <input type="text"  name="postTitle" class="form-control" placeholder="Title"/>
                                </div>
                                <div class="form-outline mb-4 shadow-sm">
                                    <textarea name="postText" id="" class="form-control" placeholder="Text" rows="5"></textarea>
                                </div>
                                <div class="form-outline mb-4 shadow-sm">
                                    <select class="form-select" name="postCategory" aria-label="Default select example">
                                        <option value="" selected disabled>Select category</option>
                                    <?php
                                    for($i = 0; $i < count($posts); $i++){
                                        echo '<option value="'.$i.'">'.$posts[$i]['category'].'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>

                                <!-- Logo input -->
                                <div class="d-flex flex-row align-items-center justify-content-center mb-4">
                                    <p class="mb-0"><strong>Img: </strong></p>
                                    <div class="form-outline w-50 mx-3">
                                        <input class="form-control" type="file" name="postImg" id="formFile">
                                    </div>
                                </div>
                                <div class="w-100 d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-success">Post</button>
                                </div>

                        
                        </form>
                        <?php
                            if(isset($_SESSION['error_msg'])){
                                echo '<div class="w-100 d-flex align-items-center justify-content-center">';
                                echo '<p style="color: red;">'.$_SESSION['error_msg'].'</p>';
                                echo '</div>';
                            }
                        ?>
                    </div>
            </div>
    




    <footer class="bg-light text-center w-100" >


        <!-- Copyright -->
        <div class="text-center p-3 ">
          © 2022 Copyright:
          <a class="text-dark" href="">Alessandro Modelli</a>
        </div>
        <!-- Copyright -->
      </footer>


</body>
</html>

<?php
    unset($_SESSION['error_msg']);
?>