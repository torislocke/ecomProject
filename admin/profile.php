<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form_update'])) {
    try {

        // Update Name and Email
        if($_POST['name'] == '') {
            throw new Exception("Full Name can not be empty");
        }
        if($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        $statement = $pdo->prepare("UPDATE admins SET 
                                    name=?, 
                                    email=? 
                                    WHERE id=?");
        $statement->execute([$_POST['name'],$_POST['email'],$_SESSION['admin']['id']]);


        // Update Password
        if($_POST['password']!='' || $_POST['retype_password']!='') {
            if($_POST['password'] != $_POST['retype_password']) {
                throw new Exception("Password does not match");
            } else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $statement = $pdo->prepare("UPDATE admins SET password=? WHERE id=?");
                $statement->execute([$password,$_SESSION['admin']['id']]);
            }
        }

        // Update Photo
        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if($path!='') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time().".".$extension;
    
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
    
            if($mime == 'image/jpeg' || $mime == 'image/png') {
                if($_SESSION['admin']['photo']!='') {
                    unlink('../uploads/'.$_SESSION['admin']['photo']);
                }
                move_uploaded_file($path_tmp, '../uploads/'.$filename);
                $statement = $pdo->prepare("UPDATE admins SET photo=? WHERE id=?");
                $statement->execute([$filename,$_SESSION['admin']['id']]);
                $_SESSION['admin']['photo'] = $filename;
            } else {
                throw new Exception("Please upload a valid photo");
            }
        }

        $success_message = 'Profile data is updated successfully!';

        $_SESSION['admin']['name'] = $_POST['name'];
        $_SESSION['admin']['email'] = $_POST['email'];

    } catch(Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profile</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if(isset($error_message)) {
                                ?><script>alert("<?php echo $error_message; ?>")</script><?php
                            }
                            if(isset($success_message)) {
                                ?><script>alert("<?php echo $success_message; ?>")</script><?php
                            }
                            ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">

                                        <?php if($_SESSION['admin']['photo'] == ''): ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="" class="profile-photo w_100_p">

                                        <?php else: ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['admin']['photo']; ?>" alt="" class="profile-photo w_100_p">

                                        <?php endif; ?>

                                        <input type="file" class="mt_10" name="photo">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['admin']['name']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $_SESSION['admin']['email']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Retype Password</label>
                                            <input type="password" class="form-control" name="retype_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label"></label>
                                            <button type="submit" class="btn btn-primary" name="form_update">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>