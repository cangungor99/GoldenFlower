<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldenFlower</title>
</head>
<body>
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
        <img src="images/logo1.png" alt="Golden GoldenFlower"
          class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
      </div>
      
      <div class="col-lg-8">
        <div class="card-body py-5 px-md-5">

          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="">
          <h1 class="mb-3" >Golden Flower </h1></div>
            <!-- Email input -->
            
            <div class="form-outline mb-4">
              <input type="text" id="form2Example1" class="form-control" name="username" required/>
              <label class="form-label" for="form2Example1">Username</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="form2Example2" class="form-control" name="password" required />
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                <a href="signup.php"><i>I do not have account.</i></a>
                  
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <a href="#!"><i>Forgot password?</i></a>
              </div>
            </div>

            <!-- Submit button 
            <button type="button" class="btn btn-primary btn-block mb-4"><a href="home.php" class="btn btn-primary btn-block mb-4">Sign in</a></button> -->
            <input type="submit" class="btn btn-primary btn-block mb-4" value="Sign in" name="sbmt">
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<?php
ob_start();
include 'db.php';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashed = md5($password);
  $sql = "SELECT * FROM user_data WHERE user_name = '$username'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $dbpassw = $row['user_password'];
  
  if(mysqli_num_rows($result) == 1){
    if($hashed == $row["user_password"]){
      $_SESSION["loggedin"] = true;
      $_SESSION["id"] = $row["id"];
      $_SESSION["username"] = $row["user_name"];
      header("location: home.php");
    }else{
      echo "Password is incorrect";
    }    
  }else{
    echo "Username is incorrect";
  }
}

ob_end_flush();
?>

</body>
</html>
</body>
</html>