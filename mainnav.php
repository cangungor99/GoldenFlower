<!-- Navigation-->
<?php
//session_start();

?>

<script src="https://kit.fontawesome.com/13b4785b74.js" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="home.php">
                   
                    <img src="images/logo-bg.png" alt="logo" height="120" width="160">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item dropdown">
                            
                        </li>
                    </ul>
                    <form class="d-flex">
                        
                        <?php 
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){ ?>
                        <a class="btn btn-outline-dark" href="cart.php" type="button">
                        
                            <i class="fa-solid fa-cart-shopping">Cart</i>
                        </a>

                            <a class="btn btn-outline-dark" href="logout.php"  type="button">
                            <i class=""></i>
                            Logout
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                        <?php }else{ ?>
                        <a class="btn btn-outline-dark" href="login.php" type="button">
                            <i class=""></i>
                            Login                            
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                        <a class="btn btn-outline-dark" href="signup.php"  type="button">
                            <i class=""></i>                            
                            Signup
                            <i class="fa-solid fa-user-plus"></i>
                        </a>
                        <?php } ?>
                    </form>
                    
                </div>
            </div>
        </nav>