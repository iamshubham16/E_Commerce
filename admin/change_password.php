<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/E_commerce/core/init.php';
  $change = $user_data['password'];
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  $old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
  $old_password=trim($old_password);
  $password=((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password=trim($password);
  $confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $password=trim($password);
  $errors=array();
  $user_id = $user_data['id'];
?>
<style>
  body{
    background-image: url("/E_commerce/images/headerlogo/background.png");
    background-size : 100vw 100vh;
    background-attachment: fixed;
  }
</style>
<div id="login-form">
  <div>
    <?php
      if($_POST){
        //form-validation
        if(empty($_POST['old_password'])||empty($_POST['password'])||empty($_POST['confirm'])){
          $errors[] = 'You must fill out all fields';
        }
      //password is more than 6 characters
      if(strlen($password)<6){
        $errors[]='Password must be of at least 6 characters';
      }
      if($password !=$confirm){
        $errors[]= 'The new password and confirm new password does not match';
      }

       if($old_password != $change){
         $errors[] = 'The old password does not match our records ';
       }

        if(!empty($errors)){
          echo display_errors($errors);
        }else{
          //change password
          $db->query("UPDATE users SET password = '$password' where id ='$user_id'");
          $_SESSION['success_flash'] = 'Your password has been updated!';
          header("Refresh:0; url='index.php'");
        }
  }
    ?>
  </div>
  <h2 class = "text-center">Change Password</h2><hr>
  <form action="change_password.php" method="post">
    <div class="form-group">
      <label for ="old_password">Old Password :</label>
      <input type = "password" name ="old_password" id='old_password' class = "form-control" value = "<?=$old_password;?>">
    </div>

      <div class="form-group">
        <label for ="password">Confirm New Password :</label>
        <input type = "password" name ="password" id='password'class = "form-control" value = "<?=$password;?>">
      </div>
    <div class="form-group">
      <label for ="confirm">Password:</label>
      <input type = "password" name ="confirm" id='confirm' class = "form-control" value = "<?=$confirm;?>">
    </div>
    <div class="form-group">
      <a href ="index.php" class="btn btn-default">Cancel</a>
      <input type="submit" value="Change Password" class="btn btn-primary">
    </div>
  </form>
  <p class = "text-right"><a href="/E_commerce/index.php" alt="home">Visit Site</a></p>
</div>
<?php include 'includes/footer.php'?>
