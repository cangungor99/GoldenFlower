<?php
session_start();
ob_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["unlogged"] = "Please login first";
    $_SESSION["unlogged"] = true;
}

// Kullanıcı giriş yapmışsa, $_SESSION['id'] değerini $user_id değişkenine atayın
if(isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
} else {
    $user_id = ""; // Varsayılan bir değer atayın
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>GoldenFlower</title>
            <!-- Favicon-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

            <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
            <!-- Bootstrap icons-->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link href="css/styles.css" rel="stylesheet" />
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
            
            <script src="https://kit.fontawesome.com/13b4785b74.js" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <style>
            body::after {
                content: "";
                background: url('images/bg.jpeg');
                background-size: 100% 100%;
                filter: blur(1px);
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }
    </style>
    </head>
    <body>


        
        
        <?php 
        include 'db.php';
        include 'mainnav.php';

        ?>
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;You need to login first!
      <p><i class="fa-solid fa-exclamation"></i>&nbsp;You can not see any price!</p>
      <p><i class="fa-solid fa-exclamation"></i>&nbsp;You can not add product to cart!</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="" href="login.php"><button type="button" href="login.php" class="btn btn-primary">Go to Login</button></a>
      </div>
    </div>
  </div>
</div>
        


            <div class="container-xxl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <h2>Products</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Filter</h5>
                                        <select class="form-select ms-1" name="product_filter" id="product_filter">
                                        <option value="All" selected>All</option>
                                        <option value="meal">Meal</option>
                                        <option value="desert">Desert</option>
                                        <option value="drink">Drink</option>
                                        </select>
                                        <input type="submit" name="" value="Filter!" class="btn btn-dark btn-rounded">

                                    </div>
                                </form>
                            </div>
                        </div>
                    
                    <div class="row">
                        <?php
                        $result = $con->query("SELECT * FROM product");
                        $product_type = filter_input(INPUT_POST,'product_filter',FILTER_SANITIZE_STRING);
                        if($product_type == "All" || $product_type == null){
                            $result = $con->query("SELECT * FROM product");
                        }else{
                            $result = $con->query("SELECT * FROM product WHERE ptype = '$product_type'");
                        }
                        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                        {
                            while($row=$result->fetch_assoc()){
                                echo "<div class='col-sm-3 mt-2'>"; // Kartları yan yana sıralar
                                echo "<div class='card' style='width: 19rem; height: 32rem;'>"; // Kartın genişliğini ayarlar
                                echo "<div class='card-body'>";
                                echo "<a class='text-reset text-decoration-none' href='product_detail.php?id=".$row['id']."'>";
                                echo "<img style='width:17rem; height: 17rem;' src='" . $row['image_path'] . "' class='card-img-top' alt='" . $row['product_name'] . "'>";
                                echo "<h5 class='card-title'>" . $row['product_name'] . "</h5></a>";
                                echo "<p class='card-text'>" . substr($row['content'],0,30) . "...</p>";
                                echo "<p class='card-text'>Price: " . $row['price'] . "</p>";
                                echo "<p class='card-text'>Type: " . $row['ptype'] . "</p>";
                                echo '<form action="';
                                echo htmlspecialchars($_SERVER["PHP_SELF"]);
                                echo  '" method="POST">';
                                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                                echo "<input type='submit' name='addcart' class='btn btn-primary' value='Add To cart'>";
                                echo "</form></div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }else{
                            echo '<script>$("#loginModal").modal("show");</script>';
                            
                        }
                        if($_SESSION["unlogged"]=== true){
                            while($row=$result->fetch_assoc()){
                                echo "<div class='col-sm-3 mt-2'>"; // Kartları yan yana sıralar
                                echo "<div class='card' style='width: 19rem; height: 32rem;'>"; // Kartın genişliğini ayarlar
                                echo "<div class='card-body'>";
                                echo "<a class='text-reset text-decoration-none' href='product_detail.php?id=".$row['id']."'>";

                                echo "<img style='width:17rem; height: 17rem;' src='" . $row['image_path'] . "' class='card-img-top' alt='" . $row['product_name'] . "'>";
                                echo "<h5 class='card-title'>" . $row['product_name'] . "</h5></a>";
                                echo "<p class='card-text'>" . substr($row['content'],0,30) . "...</p>";
                                echo "<p class='card-text'>Price: <strong><i>You need to login first!.</i></strong> </p>";
                                echo "<p class='card-text'>Type: " . $row['ptype'] . "</p>";
                                echo '<form action="';
                                echo htmlspecialchars($_SERVER["PHP_SELF"]);
                                echo  '" method="POST">';
                                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                                echo "<input type='submit' name='addcart' class='btn btn-primary' value='Add To cart'>";
                                echo "</form></div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        
                            if($_SERVER["REQUEST_METHOD"] == "POST"){
                                global $con;
                                $product_id = $_POST["product_id"];
                                $user_id = $_POST["user_id"];
                                if(empty($user_id)){
                                    
                                       return;
                                    
                                }
                                $checkCart = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
                                $checkCartResult = mysqli_query($con, $checkCart);                           
                                if(mysqli_num_rows($checkCartResult) > 0){
                                        $row = $checkCartResult->fetch_assoc();
                                        $quantitiy = $row['quantity'] + 1;
                                        $updateCart = "UPDATE cart SET quantity = '$quantitiy' WHERE product_id = '$product_id' AND user_id = '$user_id'";
                                }else{
                                    $updateCart = "INSERT INTO cart (product_id, user_id, quantity) VALUES ('$product_id', '$user_id', 1)";
                                }
                                if(mysqli_query($con, $updateCart)){
                                    echo "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Its added to cart successfully!',
                                            text: 'Your product is added to cart successfully!'
                                        });
                                        </script>";
                                }else{
                                    echo '<script>alert("Error adding product to cart");</script>';
                                }
                                
                                

                            }
                        ob_end_flush();
                        ?>
                    </div>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.js"></script>                   
            <!-- Bootstrap core JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Core theme JS-->
            <script src="js/scripts.js"></script>
    </body>
    </html>