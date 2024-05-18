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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--required-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/margin/margin.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/padding/padding.css">
    <script src="https://kit.fontawesome.com/13b4785b74.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/abouts/about-6/assets/css/about-6.css">
    <title>AboutUs</title>
</head>
<body>
<form?php 
include 'mainnav.php';

?>
<style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 900px; /* Maksimum genişliği ayarlayabilirsiniz */
        }

        .video-container video {
            width: 100%;
            height: auto;
        }
    </style>
<?php 
include 'mainnav.php';
?>
<!-- About 6 - Bootstrap Brain Component -->
<section class="bsb-about-6 py-3 py-md-5 py-xl-8">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
        <h2 class="mb-4 display-5 text-center">About Us</h2>
        <p class="text-secondary mb-5 text-center lead fs-4">Golden Flower is a meeting point for everyone who wants to enjoy the pleasure of cooking and explore the culinary arts. 
            Our site offers a wide range of recipes, from homemade dishes to exotic flavors. Each recipe is enriched with step-by-step explanations and professional tips, 
            ensuring you have everything you need to succeed in the kitchen.</p>
        <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row gy-4 gy-lg-0 align-items-lg-center">
      <div class="col-12 col-lg-6">
        <!-- mp4 -->
        <div class="video-container">
            <video autoplay muted loop>
                <source src="images/about.mp4" type="video/mp4">
                Support for HTML5 video is required.
            </video>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="row justify-content-xl-end">
          <div class="col-12 col-xl-11">
            <div class="accordion accordion-flush" id="accordionAbout6">
              <div class="accordion-item mb-4 border border-dark">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button bg-transparent fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Our Mission
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionAbout6">
                  <div class="accordion-body">
                    <p>At Golden Flower, our mission is to create a community that views cooking not just as a necessity but also as a pleasure and an art form. 
                        We are here to ensure that your time in the kitchen is enjoyable and fun, helping you to savor the process of cooking. 
                        Whether you love to cook or want to discover new flavors, we aim to be your best resource.</p>
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-4 border border-dark">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed bg-transparent fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Our Vision
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionAbout6">
                  <div class="accordion-body">
                    <p>At Golden Flower, our vision is to build a community that shares a passion for the culinary arts and enjoys the pleasure of cooking. Our goal is not only to provide recipes but also to offer a platform to explore the cultural and creative aspects of cooking. By bringing the richness and diversity of world cuisines into your homes, we aim to inspire everyone to create delicious meals. By making cooking a lifestyle, we strive to encourage people to live healthy and happy lives.</p>    
                </div>
                </div>
              </div>
              <div class="accordion-item mb-4 border border-dark">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed bg-transparent fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Contact Us
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionAbout6">
                  
                    <div class="form">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-body">
                            <div class="form-element">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Enter your name">
                            </div>
                            <div class="form-element">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Enter your email">
                            </div>
                            <div class="form-element">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" class="form-control" placeholder="Enter your message"></textarea>
                            </div>
                            <div class="form-element">
                                <button type="submit" class="btn btn-secondary" name="sbmt">Send <i class="fa-solid fa-paper-plane"></i></button>
                            </div>    
                        </div>
                    </div> </form> 
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php 
include 'footer.php';
?>
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
</body>
</html>