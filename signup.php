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

          <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
          <div class="">
          <h1 class="mb-3" >Golden Flower </h1></div>
            <!-- Email input -->
            
            <div class="form-outline mb-4">
              <label class="form-label" for="form2Example1">Name</label>

              <input type="text" id="name" name="name" class="form-control" required/>
              
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="form2Example1">E-mail</label>

              <input type="mail" id="mail" name="mail" class="form-control" required/>
              
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form2Example2">Password</label>

              <input type="password" id="password" name="passw" class="form-control" required/>
             
            </div>
            <div class="form-outline mb-4">
              <label class="form-label" for="form2Example2">Confirm Password</label>

              <input type="password" id="form2Example2" name="confmpassw" class="form-control"  required/>
             
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
                <a href="login.php">I have already an account?</a>
              </div>
            </div>

            <!-- Submit button -->
            <input type="submit" name="sbmt" class="btn btn-primary" value="Sign up">
            <input type="reset" name="reset" class="btn btn-primary" value="Clear">
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
<?php
function getData() {
    $con = mysqli_connect("localhost", "root", "", "user");
    if (!$con) {
        die("Connection error: " . mysqli_connect_error());
    }

    $errors = array();
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (strlen($_POST["name"]) < 1) {
            $errors[] = "Name must be more than 1 character";
            $sql = "SELECT user_name FROM user_data WHERE user_name =".$_POST["name"];
            $result = mysqli_query($con, $sql);
              if(mysqli_num_rows($result) ==1) {
                  $errors[] = "Username already exists";
                }
        } else {
            $uname = $_POST['name'];
        }


        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "INVALID MAIL ADDRESS";
            $sql = "SELECT user_mail FROM user_data WHERE user_mail =".$_POST['mail'];
            $result = mysqli_query($con, $sql);
                if(mysqli_num_rows($result) ==1) {
                   $errors[] = "Email already exists";
              }
        } else {
            $umail = $_POST['mail'];
        }

        
        if (strlen($_POST['passw']) < 6) {
            $errors[] = 'Password must be more than 6 characters.';
        } else {
            $upassw = $_POST['passw'];
        }
        $upassw = $_POST['passw'];

        $confirm_passw = $_POST["confmpassw"];

        if ($upassw !== $confirm_passw) {
            $errors[] = 'Passwords must be the same';
        }else{
          $hashed = md5($upassw);
        }
    }

    if (empty($errors)) {
      $sql = "INSERT INTO user_data(user_name, user_mail, user_password) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($con, $sql);
      $test = mysqli_stmt_bind_param($stmt, "sss", $uname, $umail, $hashed);
      
      if ($test) {
          mysqli_stmt_execute($stmt);
  
          echo '<script>alert("Successfully Signed up")</script>';
          header("Location: login.php");
          exit();
      } else {
          echo '<script>alert("Error While signup")</script>';
      }
  } else {
      echo '<h2>Errors:</h2>';
      echo '<ul>';
      foreach ($errors as $error) {
          echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
  }
  
}

if (isset($_POST['sbmt'])) {
    getData();
}

?>


</body>
</html>