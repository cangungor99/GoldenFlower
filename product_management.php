<!doctype html>
<html lang="en">
  <head> <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Golden Flower</title>
  </head>
  <body>

    <?php 
    ob_start();
    include 'navbar.php';
    ?>

    <div class="hero" style="background-image: url('images/background.png');">
    <br><br><br>
    
    <fieldset  align="center" class="blur-effect">
      <br><br>
    <div class="container">
      <div class="card">
        <div class="card-body">
        <table id="example" class="table table-striped" style="width:100%" name="table">
        
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Content</th>
                <th>Price</th>
                <th>Product Type</th>
                <th>Image Path</th>
                <th>Change</th>
            </tr>    

        </thead>
        <tbody>
            <?php
              ob_start();
              include 'admin_session.php';
              include "connect.php";
              $con = connectDB();
              $sql = "SELECT * FROM product";
              $result = $con->query($sql);
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>'.$row['id'].'</td>';
                  echo '<td>'.$row['product_name'].'</td>';
                  echo '<td>'.$row['content'].'</td>';
                  echo '<td>'.$row['price'].'₺</td>';
                  echo '<td>'.$row['ptype'].'</td>';
                  echo '<td>'.'<img width="100px" height="100px" src="'.$row['image_path'].'"></td>';
                  echo "<td><form method='POST' action='update_product.php'>";
                  echo "<input type='hidden' name='id' value='".$row['id']."'>";
                  echo "<input type='submit' class='btn btn-primary' value='Edit'>";
                  echo "</form>";
                  echo "<form method='POST' action=''>";
                  echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                  echo "<input type='button' class='btn btn-danger mt-1 delete-button' data-toggle='modal' data-target='#deleteModal' data-id='" . htmlspecialchars($row['id']) . "' value='Delete'>";                  echo "</form></td>";
                  echo "</tr>";


                } echo '</table>';
              }else{
                echo 'Empty database.';
              }
                

                ob_end_flush();
            ?>
        </tbody>
    </table>

        </div>
        


      </div>
    </div>


    </fieldset>
    
  </div>
    
  
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this item?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <form method="POST"id="deleteForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input type="hidden" name="id" id="deleteId" value="">
          <button type="submit" name="deleteit" class="btn btn-danger">Yes, Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $('.delete-button').click(function() {
        var productId = $(this).data('id');
        $('#deleteId').val(productId);
    });
});

</script>

<?php
if(isset($_POST['deleteit'])){
  $id = $_POST['id'];
  
  
  $stmt = $con->prepare("DELETE FROM product WHERE id = ?");
  
  
  $stmt->bind_param("i", $id);
  
  // Execute statement
  if ($stmt->execute()) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Product Deleted',
            text: 'Product deleted successfully'
        }).then(function() {
            window.location = 'product_management.php';
        });
    </script>";
} else {
    echo "Error deleting record: " . $con->error;
}

// Close statement
$stmt->close();
}
ob_end_flush();
?>



  
       


    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>