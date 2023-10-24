<?php

include 'config.php';

if(isset($_POST['submit'])){

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


    <link rel="stylesheet" href="register.css">
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
                    <a href="#">PRODUCT
                        <i class="fa-solid fa-caret-down"></i>
                    </a>
                </li>
            </ul>
        </nav>
        </div>



        <div class="subNavigationBar">
            <div class="sNBWrapper">
                <div class="groupLinks">
                    <div class="gLImg">
                        <img src="image/chlothes.jpg" />
                    </div>
                    <h2 class="subLinksHeader">CLOTHES</h2>
                    <ul class="subLists">
                        <li class="subLinks"><a href="shirts.html">SHIRTS</a></li>
                        <li class="subLinks"><a href="pants.html">PANTS</a></li>
                        <li class="subLinks"><a href="hats.html">HATS</a></li>

                    </ul>
                </div>
                <div class="groupLinks">
                    <div class="gLImg">
                        <img src="image/matching-belt-and-shoes.jpg" />
                    </div>
                    <h2 class="subLinksHeader">SHOES AND BELT</h2>
                    <ul class="subLists">
                        <li class="subLinks"><a href="shoe.html">SHOES</a></li>
                        <li class="subLinks"><a href="belts.html">BELT</a></li>
                        <li class="subLinks"><a href="neck-tie.html">NECK TIE</a></li>
                    </ul>
                </div>
                <div class="groupLinks">
                    <div class="gLImg">
                        <img src="image/wallet_.jpg" />
                    </div>
                    <h2 class="subLinksHeader">WALLET AND WATCH</h2>
                    <ul class="subLists">
                        <li class="subLinks"><a href="wallet.html">WALLET</a></li>
                        <li class="subLinks"><a href="watch.html">WATCH</a></li>
                        <li class="subLinks"><a href="glases.html">GLAS</a></li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="icons">
            <div id="menu-bar" class="fas fa-user"></div>
            <div id="theme-toggler" class="fas fa-moon"></div>

        </div>

    </header>


    <nav class="navbar">

        <div class="user">
            <img src="image/Untitled-1.png" alt="">
            <h3>shaikh anas</h3>
        </div>

        <div class="links">
            <a href="#">NIKE PRODUCT</a>
            <a href="#">PUMA PRODUCT</a>
            <a href="">.</a>

        </div>
        <div class="links">
            <a href="Login.html">LOGIN <i class="fa-sharp fa-solid fa-right-to-bracket"></i></a>
            <a href="register.html">REGISTER<i class="fa-solid fa-square-arrow-up-right"></i></a>
            <a href="">.</a>

        </div>


        <div id="close" class="fas fa-times"></div>

    </nav>

    <section class="home" id="home">

        <div class="form-container">

            <form action="" method="post" enctype="multipart/form-data">
                <h3>register Here</h3>
                <?php
          if(isset($message)){
             foreach($message as $message){
                echo '<div class="message">'.$message.'</div>';
             }
          }
          ?>
                <input type="text" name="name" placeholder="enter username" class="box" required>
                <input type="email" name="email" placeholder="enter email" class="box" required>
                <input type="password" name="password" placeholder="enter password" class="box" required>
                <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                <input type="submit" name="submit" value="register now" class="btn">
                <p>already have an account? <a href="login.php">login now</a></p>

            </form>

        </div>

    </section>




    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <script src="Java/angkorshop.js"></script>

</body>

</html>