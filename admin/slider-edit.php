<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM sliders WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'slider-view.php');
    exit;
}
?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['subheading'] == '') {
            throw new Exception('Subheading cannot be empty');
        }
        if($_POST['heading'] == '') {
            throw new Exception('Heading cannot be empty');
        }
        if($_POST['button_text'] == '') {
            throw new Exception('Button Text cannot be empty');
        }
        if($_POST['button_url'] == '') {
            throw new Exception('Button URL cannot be empty');
        }
        if($_POST['text_position'] == '') {
            throw new Exception('Text Position cannot be empty');
        }

        $statement = $pdo->prepare("UPDATE sliders SET subheading=?, heading=?, button_text=?, button_url=?, text_position=? WHERE id=?");
        $statement->execute([$_POST['subheading'], $_POST['heading'], $_POST['button_text'], $_POST['button_url'], $_POST['text_position'], $_REQUEST['id']]);

        $path1 = $_FILES['photo1']['name'];
        $path1_tmp = $_FILES['photo1']['tmp_name'];
        if($path1!='') 
        {
            $extension1 = pathinfo($path1, PATHINFO_EXTENSION);
            $filename1 = "slider_photo1_".time().".".$extension1;
            $finfo1 = finfo_open(FILEINFO_MIME_TYPE);
            $mime1 = finfo_file($finfo1, $path1_tmp);
            if($mime1 != 'image/jpeg' && $mime1 != 'image/png' && $mime1 != 'image/gif') {
                throw new Exception('Please upload a valid photo 1');
            }

            unlink('../uploads/'.$result['photo1']);
            move_uploaded_file($path1_tmp, '../uploads/'.$filename1);

            $statement = $pdo->prepare("UPDATE sliders SET photo1=? WHERE id=?");
            $statement->execute([$filename1, $_REQUEST['id']]);
        }

        $path2 = $_FILES['photo2']['name'];
        $path2_tmp = $_FILES['photo2']['tmp_name'];
        if($path2!='') 
        {
            $extension2 = pathinfo($path2, PATHINFO_EXTENSION);
            $filename2 = "slider_photo2_".time().".".$extension2;
            $finfo2 = finfo_open(FILEINFO_MIME_TYPE);
            $mime2 = finfo_file($finfo2, $path2_tmp);
            if($mime2 != 'image/jpeg' && $mime2 != 'image/png' && $mime2 != 'image/gif') {
                throw new Exception('Please upload a valid photo 2');
            }

            unlink('../uploads/'.$result['photo2']);
            move_uploaded_file($path2_tmp, '../uploads/'.$filename2);

            $statement = $pdo->prepare("UPDATE sliders SET photo2=? WHERE id=?");
            $statement->execute([$filename2, $_REQUEST['id']]);
        }

        $_SESSION['success_message'] = 'Slider has been updated successfully.';
        header('location: '.ADMIN_URL.'slider-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'slider-edit.php?id='.$_REQUEST['id']);
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM sliders WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Slider</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>slider-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
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
                                            <label>Existing Photo 1</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['photo1']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Photo 1</label>
                                            <div>
                                                <input type="file" name="photo1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Existing Photo 2</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['photo2']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Photo 2</label>
                                            <div>
                                                <input type="file" name="photo2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Subheading</label>
                                            <input type="text" class="form-control" name="subheading" value="<?php echo $result['subheading']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Heading</label>
                                            <input type="text" class="form-control" name="heading" value="<?php echo $result['heading']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Button Text</label>
                                            <input type="text" class="form-control" name="button_text" value="<?php echo $result['button_text']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Button URL</label>
                                            <input type="text" class="form-control" name="button_url" value="<?php echo $result['button_url']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Text Position</label>
                                            <select name="text_position" class="form-select">
                                                <option value="Left" <?php if($result['text_position'] == 'Left') echo 'selected'; ?>>Left</option>
                                                <option value="Right" <?php if($result['text_position'] == 'Right') echo 'selected'; ?>>Right</option>
                                            </select>
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