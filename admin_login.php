<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
</head>
<body>
    <!-- Section: Design Block -->
<section class=" text-center text-lg-start">
  <style>
    .rounded-t-5 {
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }

    @media (min-width: 992px) {
      .rounded-tr-lg-0 {
        border-top-right-radius: 0;
      }

      .rounded-bl-lg-5 {
        border-bottom-left-radius: 0.5rem;
      }
    }
  </style>
  <div class="card mb-3">
    <div class="row g-0 d-flex align-items-center">
      <div class="col-lg-4 d-none d-lg-flex">
        <img src="images/imglogin.png" alt="Trendy Pants and Shoes"
          class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
      </div>
      
      <div class="col-lg-8">
        <div class="card-body py-5 px-md-5">

          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
          <div class="">
          <h1 class="mb-3" >Golden Flower </h1></div>
            <!-- Email input -->
            
            <div class="form-outline mb-4">
              <input type="text" id="form2Example1" class="form-control" name="username"/>
              <label class="form-label" for="form2Example1">Username</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="form2Example2" class="form-control" name="password" />
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                  <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
              </div>
            </div>

            <!-- Submit button -->
            <input type="submit" name="submit" class="btn btn-primary btn-block mb-4" value="Login">

          </form>


        </div>
      </div>
    </div>
  </div>
</section>
    <?php
    include 'db.php';
    session_start();
    if(isset($_SESSION["aloggedin"]) && $_SESSION["aloggedin"] == true){
      header("location: adminpanel.php");
      die;
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $username = $_POST['username'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM admin WHERE admin = '$username' AND password = '$password'";
      $result = mysqli_query($con, $sql);
      if(mysqli_num_rows($result) == 1){
        $row=mysqli_fetch_assoc($result);
        if($password !== $row["password"]){
          echo "Password is incorrect";
          
        }else{
          $_SESSION["aloggedin"] = true;
          $_SESSION["ausername"] = $row["admin"];
          $_SESSION["aID"] = $row["id"];
          header("location: adminpanel.php");
          exit;
          
        }
      }else{
        echo "<script>alert('Username is incorrect'); </script>";
      }
    }
    
    ?>

</body>
</html>