<?php
function usernameExists()
{

    global $db; // global use for call varaiblr db pi page krav mk use 
    $query = $db->prepare('SELECT * FROM tbl_users  WHERE username = ?');  // uer for tang parameter tha mean name in database ot 
    $query->bind_param('s', $username);  //param = parameter
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {  // catch unique 
        return true;

    }
    return false;
}
function registerUser($name, $username, $password)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_users (name,username,password) VALUES (?,?,?)');
    $query->bind_param('sss', $name, $username, $password);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function logInUser($username, $password)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ? AND password = ?');
    $query->bind_param('ss', $username, $password);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    } else {
        return false;
    }

}
function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ?');
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return null;


}
?>