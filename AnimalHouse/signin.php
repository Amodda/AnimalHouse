<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/animalHouse.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title> </title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
        <div class="container-fluid my-1">
          <a class="navbar-brand " href="animalHouse.php">AnimalHouse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="authentication.html">Sign in</a>
              </li>
    
            </ul>
          </div>
        </div>
    </nav>

    <div class="container w-100 d-flex align-items-center justify-content-center mt-5">
      <div class="w-100">
        <div class=" flex-column align-items-center justify-content-center" id="userLogin" style="display: flex;">
          <h4 class="mb-5 text-center"><strong>Sign in</strong></h4>
          <div class="d-flex flex-column text-center justify-content-center w-50">
              <form action="php/authentication.php?login" method="post">


                  <!-- Username input -->
                  <div class="form-outline mb-4">
                      <input type="text"  name="usernameLogin" class="form-control" placeholder="Username" required/>
                  </div>

                  <!-- Password input -->
                  <div class="form-outline mb-4">
                      <input type="password"  name="passwordLogin" class="form-control" placeholder="Password" required/>
                  </div>

                  <div class="d-flex justify-content-center my-5">
                      <!-- Submit button -->
                      <button type="submit" class="btn btn-dark  w-50">
                      Login
                      </button>
                  </div>



              </form>
              <a class="btn btn-link" style="color: black;" href="signup.php">First time? Sign Up Now!</a>
      
          </div>
          <?php 
          if(isset($_SESSION['auth_error'])){
            echo $_SESSION['auth_error'];
          }
          ?>
      </div>

    </div>




</body>
</html>
<?php
unset($_SESSION['auth_error']);
?>