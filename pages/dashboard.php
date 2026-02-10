<?php
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
}
echo 'LEVEL: ' . (isAdmin() ? 'Admin' : 'User');  // if else statement
// if (isAdmin())  true ? show Admin  else showo User


?>

<h1>Dashboard</h1>