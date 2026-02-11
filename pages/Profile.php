<?php
$oldpassword = $newpassword = $confirm_password = '';
$oldpasswordErr = $newpasswordErr = '';
$response = null;




if (isset($_POST['changepassword'], $_POST['oldpassword'], $_POST['newpassword'], $_POST['confirm_password'])) {
    $oldpassword = trim($_POST['oldpassword']);
    $newpassword = trim($_POST['newpassword']);
    $confirmNewpassword = trim($_POST['confirm_password']);
    if (empty($oldpassword)) {
        $oldpasswordErr = 'Please input old password';
    }

    if (empty($newpassword)) {
        $newpasswordErr = 'Please input new password';
    }
    if ($newpassword !== $confirmNewpassword) {
        $newpasswordErr = 'Password not match';
    } else {
        if (!isUserHasPassword($oldpassword)) {
            $oldpasswordErr = 'Old password is incorrect';

        }
    }
    if (empty($oldpasswordErr) && empty($newpasswordErr)) {
        if (setUserNewPassword($newpassword)) {
            // Ensure database connection is established
            $dbConnection = new mysqli('localhost', 'username', 'password', 'database_name');
            if ($dbConnection->connect_error) {
                die('<div class="alert alert-danger" role="alert">Database connection failed: ' . $dbConnection->connect_error . '</div>');
            }
            header('Location: ./?page=logout');
        } else {
            echo '<div class="alert alert-danger" role="alert">try again</div>';
        }
    }

}
if (isset($_POST['deletePhoto'])) {
    $PhotoPath = './asset/img/' . $Photo;
    if (file_exists($PhotoPath) && $Photo !== 'image.png') {
        unlink($PhotoPath);
        $response = deleteUserImage();
        if ($response === true) {
            $Photo = 'image.png';
            echo '<div class="alert alert-danger" role="alert">
                Delete Image Success.
           </div>';
        }
    }
}


if (isset($_POST['uploadPhoto']) && isset($_FILES['Photo'])) {
   

    $Photo = $_FILES['Photo']['name'];
    $Photo = time() . '_' . $Photo; // Add a unique prefix to avoid overwriting files
    $targetDir = './asset/img/';
    $targetFile = $targetDir . $Photo;
    $PhotoTmp = $_FILES['Photo']['tmp_name'];
    $PhotoSize = $_FILES['Photo']['size'];
    $PhotoError = $_FILES['Photo']['error'];
    $PhotoType = $_FILES['Photo']['type'];
    $fileExt = explode('.', $Photo);
    $fileActualExt = strtolower(array_pop($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExt, $allowed)) {
        if ($PhotoError === 0) {
            if ($PhotoSize < 1000000) {
                // Ensure database connection is established
                $dbConnection = new mysqli('localhost', 'username', 'password', 'database_name');
                if ($dbConnection->connect_error) {
                    die('<div class="alert alert-danger" role="alert">Database connection failed: ' . $dbConnection->connect_error . '</div>');
                }
                if (move_uploaded_file($PhotoTmp, $targetFile)) {
                    $response = insertImage($Photo);
                    if ($response) {
                        echo '<img src="./asset/img/' . $Photo . '" class="rounded-circle" width="150" height="150">';
                    }
                    if ($response === false) {
                        echo '<div class="alert alert-danger" role="alert">
                                 Failed to insert image into the database.
                                 </div>';
                    }
                } else {
                    $response = false;
                }
                if ($response === true) {
                    echo '<div class="alert alert-success" role="alert">
                             Upload Image Success.
                             </div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                             Upload Image Unsuccess.
                             </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                         Your file is too big!
                         </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
                     There was an error uploading your file!
                     </div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
                 You cannot upload files of this type!
                 </div>';
    }

}


?>

<div class="row">
    <div class="col-6">
        <form method="post" action="./?page=profile" class="col-md-8 col-lg-6 mx-auto" enctype="multipart/form-data">
            <div class="d-flex justify-content-center" >
                <input name="Photo" type="file" id="profileUpload" hidden>
                <label role="button" for="profileUpload">
                    <img src="./asset/img/<?php echo $Photo ?>"  class="rounded-circle" width="150" height="150">
                </label>
                <?php if ( !$response  === false) { ?>
                    <div class="invalid-feedback">Upload Image Unsuccess</div>
                <?php } elseif ( $response  === true) { ?>
                    <div class="valid-feedback" >Upload Image success</div>
                <?php } ?>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit"  name="deletePhoto" class="btn btn-danger">Delete</button>
                <button type="submit"  name="uploadPhoto" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>
    <div class="col-6">
        <form method="post" action="?page=Profile" class="col-md-8 col-lg-6 mx-auto">
            <h3>Change Password</h3>
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input value="<?php echo $oldpassword ?>" name="oldpassword" type="password" class="form-control
                     <?php echo empty($oldpasswordErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $oldpasswordErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input value="<?php echo $newpassword ?>" name="newpassword" type="password" class="form-control
                     <?php echo empty($newpasswordErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $newpasswordErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="confirm_password" type="password" class="form-control">
            </div>
            <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>

        </form>

    </div>
</div>
<script>
    document.getElementById('profileUpload').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('label img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>