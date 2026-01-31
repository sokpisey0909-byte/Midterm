<?php
  $username = $password = '';
  $usernameError = $passwordError = '';

  if(isset($_POST['username'],$_POST['passwprd'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
      $usernameError = 'please input username';
    }
    if (empty($passwd)) {
        $passwdErr = 'Please input password.';
    }
    if (empty($usernameErr) && empty($passwordErr)) {

       
    }


  }
 
?> 






<form method="post" action="?page=login">
    <h3>Login page</h3>
  <div class="mb-3">
    <label  class="form-label">username</label>
   <input name="username" type="text" class="form-control 
            <?php echo empty($usernameError) ? '' : 'is-invalid' ?>
        " value="<?php echo $username ?>">
        <div class="invalid-feedback">
            <?php echo $usernameError ?>
        </div>
  <div class="mb-3">
    <labelclass="form-label">Password</label>
    <input  name="password" type="password" class="form-control <?php  echo empty($passwordError) ? '' : 'is-invalid' ?>" >
    <div class="invalid-feedback"></div> <?php echo $passwordError?></div>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
   
 