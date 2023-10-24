<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
$message = array(); // Initialize an empty array to store messages.

if(isset($_POST['update_profile'])){

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
 
    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');
 
 
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/'.$update_image;
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image is too large';
       }else{
          $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
          if($image_update_query){
             move_uploaded_file($update_image_tmp_name, $update_image_folder);
          }
          $message[] = 'image updated succssfully!';
       }
    }
 
 }

if(isset($_POST['change_password'])){
   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) && !empty($new_pass) && !empty($confirm_pass)){
      if($update_pass !== $old_pass){
         $message[] = 'Old password not matched!';
      } elseif($new_pass !== $confirm_pass){
         $message[] = 'Confirm password not matched!';
      } else {
         // Update the password
         $password_update_query = "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'";
         $password_update_result = mysqli_query($conn, $password_update_query);

         if ($password_update_result) {
            $message[] = 'Password updated successfully!';
         } else {
            $message[] = 'Failed to update password.';
         }
      }
   }
}

// Fetch the user's data after updates.
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
if(mysqli_num_rows($select) > 0){
   $fetch = mysqli_fetch_assoc($select);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <link rel="stylesheet" href="updates.css">

    <script
    src="https://kit.fontawesome.com/d6d651f030.js"
    crossorigin="anonymous"
  ></script>

</head>
<body>
 	
    


<header>
    <div id="close" ></div>

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
<?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

<form action="" method="post" enctype="multipart/form-data">

    <h4 class="font-weight-bold py-3 mb-4">
    </h4>
    <div class="cards ">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="upload">    
                    <?php
                    if($fetch['image'] == ''){
                       echo '<img src="images/default-avatar.png" width = 125 height = 125 >';
                    }else{
                       echo '<img src="uploaded_img/'.$fetch['image'].'" width = 125 height = 125>';
                    }
                    if(isset($message)){
                       foreach($message as $message){
                          echo '<div class="message">'.$message.'</div>';  
                       }
                    }
                 ?>
                    <div class="round">
                      <input type="file"  name="update_image" id = "image" accept=".jpg, .jpeg, .png">
                      <i class = "fa fa-camera" style = "color: #fff;"></i>
                    </div>
                  </div>
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list"
                        href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list"
                        href="#account-change-password" style="margin-top: 10px;">Change password</a>
                        
                </div>
                <button name="log_out" value="lot_out"  class="btn-5"><a href="login.php"><span>Log out<i class="fa-solid fa-person-walking-arrow-right"></i></span></a></button>
            </div>
            <div class="col-md-9">
                <h1>Account settings</h1>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="account-general">
                        <div class="card-body">
                            <span>user_name :</span>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                            </div>
                            <span>Email :</span>
                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                            </div>
                            
                        </div>
                        <button name="update_profile"   class="btn-5"><span>UPdate Info</span></button>

                    </div>
                    <div class="tab-pane fade" id="account-change-password">
                        <div class="card-body pb-2">
                            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                            <span>Old password:</span>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="update_pass" placeholder="enter previous password" class="box">
                            </div>
                            <span>New password :</span>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="new_pass" placeholder="enter new password" class="box">
                            </div>
                            <span>Confirm Password:</span>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
                            </div>
                          
                        </div>

                        <button name="change_password"  class="btn-5"><span>CAHNGE PASSWORD</span></button>

                    </div>
                </div>
   
            </div>
        </div>    
    </div>    
</form> 
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"> </script>




<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="Java/angkorshop.js"></script>


</body>
</html>