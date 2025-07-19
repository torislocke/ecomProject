<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {
        $path = $_FILES['favicon']['name'];
        $path_tmp = $_FILES['favicon']['tmp_name'];
        if($path!='') 
        {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = "favicon_".time().".".$extension;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
            if($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
                throw new Exception('Please upload a valid favicon');
            }

            $statement = $pdo->prepare("SELECT * FROM settings WHERE id=?");
            $statement->execute([1]);
            $setting_data = $statement->fetch(PDO::FETCH_ASSOC);

            unlink('../uploads/'.$setting_data['favicon']);

            move_uploaded_file($path_tmp, '../uploads/'.$filename);

            $statement = $pdo->prepare("UPDATE settings SET favicon=? WHERE id=?");
            $statement->execute([$filename, 1]);
        }

        $_SESSION['success_message'] = 'Favicon has been updated successfully.';
        header('location: '.ADMIN_URL.'setting-favicon.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'setting-favicon.php');
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
            <h1>Edit Favicon</h1>
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
                                            <label>Existing Favicon</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['favicon']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Favicon</label>
                                            <div>
                                                <input type="file" name="favicon">
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