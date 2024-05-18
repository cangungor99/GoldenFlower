<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <title>Edit Product</title>
</head>
<body>
<style>
        body::after {
        content: "";
        background: url('images/background.png');
        background-repeat: no-repeat;
        background-size: cover;
        filter: blur(1px);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }
    </style>
    <?php
    ob_start();
    include 'admin_session.php';
    include 'navbar.php';
    include 'db.php';
    
    global  $con;
    $id = $_POST['id'];
    $sql = "SELECT * FROM product WHERE id = $id";
    $result = $con -> query($sql);
    $row = mysqli_fetch_assoc($result);
    
    ?>
    <br>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card w-50">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="name">Product Name :</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['product_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Content :</label>
                        <input type="text" class="form-control" id="content" name="content" value="<?php echo $row['content']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" id="text" name="text" value="<?php echo $row['price']; ?>">
                    </div>
                    <div class="form-group">
                       
                        <label class="form-control-label px-3">Type<span class="text-danger"> *</span></label> 
                        <select class="select" name="ptype">
                        <option  value="1">Meal</option>
                        <option value="2">Drink</option>
                        <option value="3">Desert</option>
                        
                        </select> 
                    </div>
                    <div class="form-group">
                        <label for="type">İmage</label>
                        <img src="<?php echo $row['image_path']; ?>" alt="" width="100px" height="100px">
                        <input type="file" class="form-control" id="image" name="image" value="<?php echo $row['image_path']; ?>">
                    </div>
                    <div class="form-group text-center">
                        <input type="reset" class="btn btn-warning" value="Reset"></input>
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
function updateProduct(){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        global $con;
        $id = $_POST['id'];
        $name = $_POST['name'];
        $content = $_POST['content'];
        $price = $_POST['text'];
        $ptype = $_POST['ptype'];
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES['image']['tmp_name']);
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            $sql = "UPDATE product SET product_name = '$name', content = '$content', price = '$price', ptype = '$ptype', image_path = '$target_file' WHERE id = $id";  
            if ($con->query($sql) === TRUE) {
                header("Location: product_management.php");
            } else {
                echo "Error updating record: " . $con->error;
            }
        }else {
            $sql = "UPDATE product SET product_name = '$name', content = '$content', price = '$price', ptype = '$ptype' WHERE id = $id";
            if ($con->query($sql) === TRUE) {
                header("Location: product_management.php");
            } else {
                echo "Error updating record: " . $con->error;
            }
        }        
    }
}
if(isset($_POST['submit'])){
   updateProduct();
}
ob_end_flush();
?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
  
</body>
</html>