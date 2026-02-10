<?php
$oldpassword = $newpassword = $confirm_password = '';
$oldpasswordErr = $newpasswordErr = '';


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
            header('Location: ./?page=logout');
        } else {
            echo '<div class="alert alert-danger" role="alert">try again</div>';
        }
    }

}

?>

<div class="row">
    <div class="col-6">
        <form method="post" action=".?page=Profile">
            <div class="d-flex justify-content-center">
                <input name="photo" type="file" id="profileUpload" hidden>
                <label role="button" for="profileUpload">
                    <img src="">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="deletedPhoto" class="btn btn-danger">Deleted</button>
                <button type="submit" name="uploadPhoto" class="btn btn-success">Upload</button>
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