<?php
  $nameError = $usernameError = $passwordError = "";
  $name = $username = '';

  if(isset($_POST['name'],$_POST['username'],$_POST['password'],$_POST['confirm_password'])){

    $name =trim( $_POST['name']);  //trim for cut pasce left right 
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    if(empty($name)){
      $nameError = "please input name!";
    }
    if(empty($username)){
      $usernameError = "please input username!";
    }
    if(empty($password)){
      $passwordError = "please input password!";
    }
    if(strlen($password) >25 || strlen($password) <6){   //String lenght

    }
    
    if($password!== $confirm_password){
      $passwordError = 'password does not match';
    }
    if(empty($nameError) && empty($usernameError) && empty($passwordError)){
      if(registerUser($name,$username,$password)){
        $name = $username = '';

        echo  '<div class="alert alert-success" role="alert">
                A simple success alert—check it out!
              </div>';
      }
      else{
        echo'<div class="alert alert-danger" role="alert">
              A simple danger alert—check it out!
              </div>';
      }
    }
      

  } 
  ?>



<form  action="?page=register" method="post" class="col-md-8 col-lg-6 mx-auto">
    <h3>Register</h3>
  <div class="mb-3">
    <label for="Name" class="form-label">Name</label>
    <input name="name" value="<?php  echo $name ?>" type="text" class="form-control
     <?php echo empty($nameError)? '' : 'is-invalid'; ?>">
     <div class="invalid-feedback">
      <?php echo $nameError; ?></div>
   
   
  </div>
    <div class="mb-3">
    <label class="form-label">username</label>
    <input name="username" value="<?php  echo $username?>" type="text" class="form-control
     <?php echo empty($usernameError)? '' : 'is-invalid'; ?>">
     <div class="invalid-feedback"><?php echo $usernameError;?></div>
   
   
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input name="password" type="password" class="form-control <?php echo empty($passwordError)? '' : 'is-invalid'; ?>">
    <div class="invalid-feedback"><?php echo $passwordError;?></div>
  </div>
    <div class="mb-3">
    <label class="form-label"> Confirm Password</label>
    <input name="confirm_password" type="password" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>  

 