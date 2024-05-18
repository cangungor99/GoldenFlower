
<?php
include 'admin_session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/bootstrap.js"></script>
    <script src="js/add.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/add.css">
    <title>Add product</title>
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
    include 'navbar.php';
    ?>
<div class="container-fluid px-1 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
        <br>    
        <div class="card">
        <h3 class="">Add Product</h3>
            <p class="blue-text">Just answer a few questions<br> so that we can personalize the right experience for you.</p>
            
                <h5 class="text-center mb-4">Please enter the additional product information you'd like to add.</h5>
                <form class="form-card" name="product" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Product name<span class="text-danger"> *</span></label> <input type="text" id="fname" name="fname" placeholder="Enter product name" onblur="validate(1)"> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Description<span class="text-danger"> *</span></label> <input type="text" id="lname" name="pdesc" placeholder="Enter description to product" onblur="validate(2)"> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Price<span class="text-danger"> *</span></label> <input type="number" id="price" name="price" placeholder="" onblur="validate(3)"> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Type<span class="text-danger"> *</span></label> 
                        <select class="select" name="ptype">
                        <option  value="1">Meal</option>
                        <option value="2">Drink</option>
                        <option value="3">Desert</option>
                        
</select> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Upload file<span class="text-danger"> *</span></label> 
                        <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" />
 </div>
                    </div>
                    
                    <div class="form-group col-sm-15"> <input class="btn btn-danger" type="submit" value="Add Product" name="add_product"> <input class="btn btn-danger" type="reset" value="Reset"> </div>
                    <div class="form-group col-sm-6"> </div>
                 
                </form>
                <?php
                
function add_product(){
    $con = new mysqli("localhost","root","","user");
    if($con->connect_error){
        die("Database Connection Eror". $con->connect_error);
    }
    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $product_name = $_POST['fname'];
        $product_description = $_POST['pdesc'];
        $product_price = $_POST['price'];
        $product_type = $_POST['ptype'];

       
        if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){
            $product_file = $_FILES['avatar']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir. basename($_FILES["avatar"]["name"]);
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "File ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " uploaded succesfully.";
            } else {
                echo "Upload Fail.";
            }
        } else {
            $product_file = ''; 
        }

        switch ($product_type) {
            case "1":
                $selected_type = 'Meal';
                break;
            case  "2":
                $selected_type = 'Drink';
                break;
            case "3" :
                $selected_type = 'Desert';
                break;
        }

        $sql = 'INSERT INTO product (product_name,content,price,ptype,image_path) VALUES (?,?,?,?,?)';	
        if($stmt = $con->prepare($sql)){
            $stmt->bind_Param('sssss', $product_name,$product_description,$product_price,$selected_type,$target_file);
            if($stmt->execute()){
                echo 'New product succesfully uploaded';
                echo '<script>Swal.fire({
                    
                    icon: "success",
                    title: "Your work has been saved",
                    text: "Click OK to continue",
                  });</script>';
            }else{
                echo 'Error: '.$stmt->error;
            }
            $stmt->close();
        }
    }
    $con->close();
}

if(isset( $_POST['add_product'])){
    add_product() ;
}
?>
            </div>
        </div>
    </div>
</div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.js"></script>
</body>
</html>