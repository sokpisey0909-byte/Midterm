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
function isAdmin()
{
    $user = loggedInUser();
    if ($user && $user->Level === 'admin') {
        return true;
    }
    return false;
}
function isUserHasPassword($password)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ? AND password = ?');

    $query->bind_param('ss', $user->id, $password);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}

function setUserNewPassword($password)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('UPDATE tbl_users SET password = ? WHERE id = ?');
    $query->bind_param('ss', $password, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function insertImage($file){
    global $db;
    $image_name = $file["Photo"]["name"];
    $image_temp = $file["Photo"]["tmp_name"];

    $db->begin_transaction();

    $query = $db->prepare("UPDATE tbl_users SET Photo = ? WHERE id = ?");
    $query ->bind_param('sd', $image_name, $_SESSION['user_id']);
    $query -> execute();
    if (!$query->affected_rows) {
        $db->rollback();
        return false;
    }
    if(! move_uploaded_file($image_temp, "./asset/img/emptyuser.png" . $image_name)){
        $db->rollback();
        return false;
    }
    $db->commit();
    
    return true;
}
function getUserImage($user_id){
    global $db;
    $query = $db->prepare("SELECT Photo FROM tbl_users WHERE id = ?");
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows){
        return $result->fetch_object()->Photo;
    }
    return null;
}

function deleteUserImage(){
    global $db;
    $user = loggedInUser();
    $query = $db->prepare("UPDATE tbl_users SET Photo = NULL WHERE id = ?");
    $query->bind_param('d', $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
?>