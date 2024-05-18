<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/main.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <title>Customer Management</title>
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
include 'admin_session.php';
include 'navbar.php';
include 'db.php';
ob_start();

?>
<br><br><br><br><br>
    <div class="container">
        <div class="card">
            <div class="card-body">
            <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM user_data";
    $result = mysqli_query($con, $sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['user_name']."</td>";
            echo "<td>".$row['user_mail']."</td>";
            echo "<td>".$row['user_password']."</td>";
            
            echo '<form method="POST" action="update_customer.php"> <input type="hidden" name="id" value="'.$row['id'].'">';  
            echo "<td><input type='submit' class='btn btn-primary' value='Update'></form>";
            echo '<form action="delete_customer.php?id='.$row['id'].'" method="post">
                  <input type="hidden" name="id" value="'.$row['id'].'">';
                  
            echo '<button type="button" class="btn btn-danger mb-1 deleteBtn" data-id="'.$row['id'].'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                             
        }
    }
    ?>
  </tbody>
</table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="deleteForm">
        <input type="hidden" name="id" id="deleteId">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" name="confirmdelete" id="confirmDelete">Delete</button>
    </form>
</div>
    </div>
  </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });
});
$('.deleteBtn').click(function() {
    var id = $(this).data('id');
    $('#deleteId').val(id);
});
$(document).ready(function() {
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#deleteId').val();
        $.ajax({
            type: "POST",
            url: 'cus_management.php',
            data: {confirmdelete: '1', id: id},
            success: function() {
                // Reload the page to execute the echoed JavaScript code
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'AJAX Error',
                    text: 'Error making AJAX request: ' + textStatus
                });
            }
        });
    });
});
</script>

    <?php 
    
    
    if(isset($_POST['confirmdelete'])){
      $id = $_POST['id'];
      $stmt = $con->prepare("DELETE FROM user_data WHERE id = ?");
      $stmt->bind_param("i", $id);
      $result = $stmt->execute();
      if($result){
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'User Deleted',
            text: 'User deleted successfully'
        }).then(function() {
            window.location = 'cus_management.php';
        });
        </script>";
    } else {
        echo "<script>
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error deleting user'
        }).then(function() {
            window.location = 'cus_management.php';
        });
        </script>";
    }
    $stmt->close();
  }
  ob_end_flush();

?>
    
    
    
   
</body>
</html>