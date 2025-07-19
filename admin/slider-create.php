<?php include 'layouts/top.php'; ?>

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

        $path1 = $_FILES['photo1']['name'];
        $path1_tmp = $_FILES['photo1']['tmp_name'];
        if($path1=='') {
            throw new Exception('Please select a photo 1');
        }

        $extension1 = pathinfo($path1, PATHINFO_EXTENSION);
        $filename1 = "slider_photo1_".time().".".$extension1;
        $finfo1 = finfo_open(FILEINFO_MIME_TYPE);
        $mime1 = finfo_file($finfo1, $path1_tmp);
        if($mime1 != 'image/jpeg' && $mime1 != 'image/png' && $mime1 != 'image/gif') {
            throw new Exception('Please upload a valid photo 1');
        }

        $path2 = $_FILES['photo2']['name'];
        $path2_tmp = $_FILES['photo2']['tmp_name'];
        if($path2=='') {
            throw new Exception('Please select a photo 2');
        }

        $extension2 = pathinfo($path2, PATHINFO_EXTENSION);
        $filename2 = "slider_photo2_".time().".".$extension2;
        $finfo2 = finfo_open(FILEINFO_MIME_TYPE);
        $mime2 = finfo_file($finfo2, $path2_tmp);
        if($mime2 != 'image/jpeg' && $mime2 != 'image/png' && $mime2 != 'image/gif') {
            throw new Exception('Please upload a valid photo 2');
        }

        move_uploaded_file($path1_tmp, '../uploads/'.$filename1);
        move_uploaded_file($path2_tmp, '../uploads/'.$filename2);

        $statement = $pdo->prepare("INSERT INTO sliders (photo1, photo2, subheading, heading, button_text, button_url, text_position) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->execute([$filename1, $filename2, $_POST['subheading'], $_POST['heading'], $_POST['button_text'], $_POST['button_url'], $_POST['text_position']]);

        $_SESSION['success_message'] = 'Slider has been created successfully.';
        header('location: '.ADMIN_URL.'slider-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'slider-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Slider</h1>
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
                                            <label>Photo 1</label>
                                            <div>
                                                <input type="file" name="photo1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Photo 2</label>
                                            <div>
                                                <input type="file" name="photo2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Subheading</label>
                                            <input type="text" class="form-control" name="subheading">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Heading</label>
                                            <input type="text" class="form-control" name="heading">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Button Text</label>
                                            <input type="text" class="form-control" name="button_text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Button URL</label>
                                            <input type="text" class="form-control" name="button_url">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Text Position</label>
                                            <select name="text_position" class="form-select">
                                                <option value="Left">Left</option>
                                                <option value="Right">Right</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form1">Submit</button>
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