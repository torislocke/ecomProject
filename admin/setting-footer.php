<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {
        
        if($_POST['copyright_text'] == '') {
            throw new Exception('Copyright Text cannot be empty.');
        }

        $statement = $pdo->prepare("UPDATE settings SET copyright_text=? WHERE id=?");
        $statement->execute([$_POST['copyright_text'], 1]);

        $_SESSION['success_message'] = 'Copyright Text has been updated successfully.';
        header('location: '.ADMIN_URL.'setting-footer.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'setting-footer.php');
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
            <h1>Edit Footer Information</h1>
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
                                            <label>Copyright Text *</label>
                                            <input type="text" name="copyright_text" class="form-control" value="<?php echo $result['copyright_text']; ?>">
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