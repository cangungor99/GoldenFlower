<?php
ob_start();
session_start();
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Favicon-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="scss/loader.scss">
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://kit.fontawesome.com/13b4785b74.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <title>GoldenFlower-Cart</title>

</head>
<body>
    <?php
    include 'mainnav.php';
    ?>
    <script> 
   function changeQuantity(id, change) {
    var quantityElement = document.getElementById("quantity" + id);
    var quantity = parseInt(quantityElement.value) + change;
    if (quantity < 0) quantity = 0;
    quantityElement.value = quantity;

    console.log("Changing quantity for ID: " + id + " to " + quantity);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log("Response status: " + xhr.status);
            console.log("Response text: " + xhr.responseText);

            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                    //window.location.reload();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);

                }
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Unexpected error occurred.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                setTimeout(function () {
                        window.location.reload();
                    }, 1000);

            }
        }
    };
    var data = "id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity);
    console.log("Sending data: " + data);
    xhr.send(data);
}

function setDeleteId(id) {
  document.getElementById("modalInputId").value = id;
}
function updatePrices(id, quantity, change){
    document.getElementById("quantity" + id).value = quantity;

    // Calculate new line total
    var price = parseFloat(document.getElementById("price" + id).innerText);
    var newLineTotal = price * quantity;
    document.getElementById("lineTotal" + id).innerText = newLineTotal.toFixed(2);

    // Update total price
    var totalPriceElement = document.getElementById("totalPrice");
    var currentTotalPrice = parseFloat(totalPriceElement.innerText);
    var priceChange = price * change;
    var newTotalPrice = currentTotalPrice + priceChange;
    totalPriceElement.innerText = newTotalPrice.toFixed(2);
}
</script>
<div class="container-fluid">
        <div class="row">
            <aside class="col-lg-9">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-borderless table-shopping-cart">
                            <thead class="text-muted">
                                <tr class="small text-uppercase">
                                    <th scope="col">Product</th>
                                    <th scope="col" width="120">Quantity</th>
                                    <th scope="col" width="120">Add/Remove</th>
                                    <th scope="col" width="120">Price</th>
                                    <th scope="col" width="120">Line Total</th>
                                    <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                        <!-- cart item -->
                                        <?php
include 'db.php';
global $con;
//
if(isset($_POST['confirmdelete'])){
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        // handle invalid ID error
    } else {
        $stmt = $con->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            echo "<script>alert('Record deleted successfully');</script>";
            header("Location: cart.php");
        }else{
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    }
}
$totalPrice = 0;

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM cart WHERE user_id = $user_id";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)){
        $product_id = $row['product_id'];
        $product = $con->query("SELECT * FROM product WHERE id = $product_id")->fetch_assoc();
        echo '<tr><td>';
        echo '<figure class="itemside align-items-center">';
        echo '<div class="aside"><img src="'.$product['image_path'].'" class="img-sm"></div>';
        echo '<figcaption class="info">';
        echo '<a href="#" class="title text-dark" data-abc="true">'.$product['product_name'].'</a>';
        echo '<p class="text-muted small">TYPE: '.$product['ptype'].'  </p>';
        echo '</figcaption>';
        echo '</figure>';
        echo '</td>';
        echo '<td> <input type="number" id="quantity'.$row['id'].'" class="form-control form-control-sm" value="'.$row['quantity'].'"> </td>';
        echo '<td>';
        echo '<button type="button" class="btn btn-success" onclick="changeQuantity('.$row['id'].', 1)">Increase</button>';
        echo '<button type="button" class="btn btn-danger" onclick="changeQuantity('.$row['id'].', -1)">Decrease</button>';
        echo '</td>';
        
        echo '</td>';
        echo '<td>';
        echo '<div class="price-wrap"> <var class="price" id="price">'.$product['price'].'₺</var>  </div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="price-wrap"> <var class="price" id="linetotal">'.(($product['price'])*($row['quantity'])).'₺</var>  </div>';
        echo '</td>';
        echo '<td class="text-right d-none d-md-block">';
        
        echo '<button type="button" name="delete" class="btn btn-warning btn-round" data-abc="true" onclick="setDeleteId('.$row['id'].')" data-toggle="modal" data-target="#confirmModal">Remove</button>';        echo '</td></tr>';
        
        $totalPrice += $product['price'] * $row['quantity'];
    }
    }else{
        echo "Cart is empty";
    }
    
    
    echo '<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="exampleModalLabel">Confirm Removal</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo 'Are you sure you want to remove this item?';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
    echo '<form action="';
    echo 'cart.php';
    echo '" method="post"><input type="hidden" id="modalInputId" name="id" value="">';
    echo '<input type="submit" class="btn btn-danger" name="confirmdelete" value="Delete!"></form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    
?>
                                </tr>
                                
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </aside>
            <aside class="col-lg-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <form>
                            <div class="form-group"> <label>Have coupon?</label>
                                <div class="input-group"> <input type="text" class="form-control coupon" name="" placeholder="Coupon code"> <span class="input-group-append"> <button class="btn btn-primary btn-apply coupon">Apply</button> </span> </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dl class="dlist-align">
                            <dt id="subtotal">Sub Total:</dt>
                            <?php
                            
                            echo '<dd class="text-right text-dark b">$'.$totalPrice.'₺</dd>';
                            ?>
                            
                        </dl>
                        <dl class="dlist-align">
                            <dt id="">Tax:</dt><?php 
                            $tax = ($totalPrice * 8)/100;
                            echo '<dd class="text-right text-dark b"> '.$tax.'₺</dd>';
                            ?>
                            
                        </dl>
                        <dl class="dlist-align">
                            <dt id="total-price">Total Price:</dt>
                            <?php
                            $subtotal = $totalPrice + $tax;
                            echo '<dd class="text-right text-dark b">$'.$subtotal.'₺</dd>';
                            ?>
                            
                        </dl>
                        <hr> <a href="#" class="btn btn-out btn-primary btn-square btn-main" data-abc="true"> Make Purchase </a> <a href="home.php" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true">Continue Shopping</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal içeriği -->s
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
        
        <?php 
        include 'footer.php';
        ob_end_flush();
        ?>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
     <!-- Bootstrap core JS-->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>

</html>