<?php

include 'config.php';
session_start();

if(isset($_POST['login'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}


if(isset($_POST['register'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
 
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
 
    if(mysqli_num_rows($select) > 0){
       $message[] = 'user already exist'; 
    }else{
       if($pass != $cpass){
          $message[] = 'confirm password not matched!';
       }elseif($image_size > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');
 
          if($insert){
             move_uploaded_file($image_tmp_name, $image_folder);
             $message[] = 'registered successfully!';
             header('location:login.php');
          }else{
             $message[] = 'registeration failed!';
          }
       }
    }
 
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete responsive e-commerce website design tutorial</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <link rel="stylesheet" href="Login.css">
    <script src="https://kit.fontawesome.com/d6d651f030.js" crossorigin="anonymous"></script>

</head>

<body>




    <header>

        <div class="logo">
            <img src="image/logo/angkor.png" alt="">

        </div>
        <nav class="navigationBar">
            <ul class="navLists">
                <li class="navLinks"><a href="#">HOME</a></li>
                <li class="navLinks toggle">
                    <a href="#">ABOUT US
                        <i class="fa-solid fa-caret-down"></i>
                    </a>
                </li>
            </ul>
        </nav>
        </div>







        <div class="icons">
            <div id="menu-bar" class="fas fa-user"></div>
            <div id="theme-toggler" class="fas fa-moon"></div>

        </div>

    </header>


    <nav class="navbar">

        <div class="user">
            <img src="image/logo/angkor.png" alt="">
            <h3>USER PROFILE</h3>
        </div>

        <div class="links">
            <a href="#">USER NAME :</a>
            <a href="#">EMAIL :</a>
            <a></a>

        </div>
        <div class="links1">
            <a href="Login.html">LOG OUT <i class="fa-sharp fa-solid fa-right-to-bracket"></i></a>


        </div>


        <div id="close" class="fas fa-times"></div>

    </nav>

    <div class="container">
        <div class="signin-signup">
            <form action="" method="post" enctype="multipart/form-data" class="sign-in-form">
                <h2 class="title">Sign in</h2>
                <?php
          if(isset($message)){
             foreach($message as $message){
                echo '<div class="message">'.$message.'</div>';
             }
          }
          ?>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" required placeholder="enter email" class="box">`
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" required placeholder="enter password"
                        class="box">
                    <i class="fa-regular fa-eye-slash" id="eye-open"></i>
                </div>
                <button name="login" class="btn-5"><span>LOGIN</span></button>


                <p class="social-text">Or Sign in with social platform</p>
                <div class="social-media">
                    <a href="#" class="social-iconf">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="" class="social-iconW">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="" class="social-iconI">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="" class="social-iconG">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
            </form>

            <form action="" method="post" enctype="multipart/form-data" class="sign-up-form">
                <h2 class="title">Sign up</h2>

                <?php
          if(isset($message)){
             foreach($message as $message){
                echo '<div class="message">'.$message.'</div>';
             }
          }
          ?>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="enter username" class="box" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="enter email" class="box" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="enter password" class="box" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-image"></i>
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                </div>
                <button name="register" class="btn-5"><span>SING UP</span></button>

                <p class="social-text">Or Sign in with social platform</p>
                <div class="social-media">
                    <a href="#" class="social-iconf">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="" class="social-iconW">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="" class="social-iconI">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="" class="social-iconG">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
            </form>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <img src="image/logo/angkor.png">
                    <h3>WELCOME TO ANGKOR SHOPE</h3>
                    <p>If you want to buy something, You can buy in ANGKOR_SHOP 👌<br>
                        If you are a member of ANGKOR_SHOP You can get discount % 🤝

                    </p>
                    <button class="btn-5" id="sign-in-btn"><span>SIGN IN</span></button>
                </div>
                <img src="signin.svg" alt="" class="image">
            </div>
            <div class="panel right-panel">
                <div class="content">

                    <img src="image/logo/angkor.png">
                    <h3>WELCOME TO ANGKOR SHOPE</h3>
                    <p>If you want to buy something, You can buy in ANGKOR_SHOP 👌<br>
                        If you are a member of ANGKOR_SHOP You can get discount % 🤝

                    </p>
                    <button class="btn-5" id="sign-up-btn"><span>SIGN UP</span> </button>
                </div>
                <img src="signup.svg" alt="" class="image">
            </div>
        </div>
    </div>




    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <script src="Java/angkorshop.js"></script>
    <script src="js.js"></script>

</body>

</html>