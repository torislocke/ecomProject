<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['terms_content'] == '') {
            throw new Exception('Terms content cannot be empty');
        }
        if($_POST['privacy_content'] == '') {
            throw new Exception('Privacy content cannot be empty');
        }

        $statement = $pdo->prepare("UPDATE pages SET terms_content=?, privacy_content=? WHERE id=?");
        $statement->execute([
            $_POST['terms_content'],
            $_POST['privacy_content'],
            1
        ]);

        $_SESSION['success_message'] = 'Terms and Privacy content has been updated successfully.';
        header('location: '.ADMIN_URL.'terms-privacy-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'terms-privacy-view.php');
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM pages WHERE id=?");
$statement->execute([1]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Terms and Privacy Page Content</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Terms Content *</label>
                                            <textarea class="form-control editor" name="terms_content" rows="5"><?php echo $result['terms_content']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Privacy Content *</label>
                                            <textarea class="form-control editor" name="privacy_content" rows="5"><?php echo $result['privacy_content']; ?></textarea>
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