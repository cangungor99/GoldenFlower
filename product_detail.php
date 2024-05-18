<?php
session_start();
ob_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["unlogged"] = "Please login first";
    $_SESSION["unlogged"] = true;
}
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $_SESSION["loggedin"] = true;
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
    <title>Golden Flower </title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.css">

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php 
    include 'db.php';
    
    include 'mainnav.php';
    
    $id = $_GET['id'];
    $stmt = $con->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    ?>
    
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['image_path']; ?>" /></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder"><?php echo $row['product_name']; ?></h1>
                    <div class="small mb-1"><?php echo $row['ptype']; ?></div>
                    <div class="fs-5 mb-5"><span><?php echo $row['price']; ?>₺</span></div>
                    <p class="lead"><?php echo $row['content']; ?></p>
                    <div class="d-flex">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php 
    if(isset($_SESSION['unlogged'])==true){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You need to login first!'
            });
            </script>";
        }
    }
    if(isset($_SESSION['loggedin'])==true){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
            $product_id = $_POST['product_id'];
            $stmt = $con->prepare("INSERT INTO cart (product_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $product_id, $user_id);
            if ($stmt->execute()) {
                echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Product added to cart!',
                text: 'Enjoy shopping!'
            });
            </script>";
        }
            } else {
                return;
            }
            $stmt->close();
        }
    
    
    
    ?>
    
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.js"></script>
</body>
</html>
