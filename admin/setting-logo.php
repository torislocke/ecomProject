<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {
        $path = $_FILES['logo']['name'];
        $path_tmp = $_FILES['logo']['tmp_name'];
        if($path!='') 
        {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = "logo_".time().".".$extension;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
            if($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
                throw new Exception('Please upload a valid logo');
            }

            $statement = $pdo->prepare("SELECT * FROM settings WHERE id=?");
            $statement->execute([1]);
            $setting_data = $statement->fetch(PDO::FETCH_ASSOC);

            unlink('../uploads/'.$setting_data['logo']);

            move_uploaded_file($path_tmp, '../uploads/'.$filename);

            $statement = $pdo->prepare("UPDATE settings SET logo=? WHERE id=?");
            $statement->execute([$filename, 1]);
        }

        $_SESSION['success_message'] = 'Logo has been updated successfully.';
        header('location: '.ADMIN_URL.'setting-logo.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'setting-logo.php');
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM settings WHERE id=?");
$statement->execute([1]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Logo</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Existing Logo</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['logo']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Logo</label>
                                            <div>
                                                <input type="file" name="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form1">Update</button>
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