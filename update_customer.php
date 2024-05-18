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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <title>User Edit</title>
</head>
<body>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
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
    include 'db.php';
    include 'navbar.php';
    global $con;
    $id = $_POST['id'];
    $sql = "SELECT * FROM user_data WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $row = $result->fetch_assoc();
    ?>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card w-50">
            <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" class="form-control" id="name" name="username" value="<?php echo $row['user_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['user_mail']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Hashed Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['user_password']; ?>" readonly>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">
                        Change Password
                    </button>
                </div>
                <div class="form-group text-center mt-3">
                    <input type="reset" class="btn btn-warning" value="Reset">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>
            <!-- Password Change Modal -->
            <form id="changePasswordForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="newPassword">New Password:</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password:</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>
                            </div>
                            <div class="modal-footer">
                                
                                <input class="btn btn-secondary" data-bs-dismiss="modal" value="Close">
                                <input type="submit" id="change-pass" name="change-pass" class="btn btn-primary" value="Change Password">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            </div>
            <div class="card-footer">
                <div class="form-group text-center mt-3">
                    <div role="alert" id="alert"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    function updateUser() {
        global $con;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            
            $stmt = $con->prepare("UPDATE user_data SET user_name = ?, user_mail = ? WHERE id = ?");
            $stmt->bind_param("ssi", $username, $email, $id);
    
            if ($stmt->execute()) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'User Updated',
                        text: 'User updated successfully'
                    }).then(function() {
                        window.location = 'cus_management.php';
                    });
                </script>";
            } else {
                echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: ' + $stmt->error;
                      document.getElementById('alert').classList.add('alert', 'alert-danger');</script>" ;
            }
        }
    }
    
    

    function updatePassword() {
        global $con;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword == $confirmPassword) {
                $hashed = md5($newPassword);

                 $stmt = $con->prepare("UPDATE user_data SET user_password = ? WHERE id = ?");
                 $stmt->bind_param("si", $hashed, $id);

                //$sql = "UPDATE user_data SET user_password = '$hashed' WHERE id = $id";
                
                 $result = $stmt->execute();   

                if ($result === TRUE) {
                    echo "<script>document.getElementById('alert').innerHTML = 'Password updated successfully';
                    document.getElementById('alert').classList.add('alert', 'alert-success');
                    </script>";
                } else {
                    echo "<script>document.getElementById('alert').innerHTML = 'Error updating record: $con->error';
                    document.getElementById('alert').classList.add('alert', 'alert-danger');";
                }
            } else {
                echo "<script>document.getElementById('alert').innerHTML = 'Passwords do not match';
                document.getElementById('alert').classList.add('alert', 'alert-danger');</script>";
            }
        }
    }
    if(isset($_POST['submit'])){
        updateUser();
    }
    if(isset($_POST['change-pass'])){
        updatePassword();
    }
    
?>
</body>
</html>