<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['theme_color'] == '') {
            throw new Exception('Theme Color cannot be empty.');
        }

        $statement = $pdo->prepare("UPDATE settings SET theme_color=? WHERE id=?");
        $statement->execute([$_POST['theme_color'], 1]);

        $_SESSION['success_message'] = 'Theme Color has been updated successfully.';
        header('location: '.ADMIN_URL.'setting-theme-color.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'setting-theme-color.php');
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
                                            <label>Theme Color *</label>
                                            <input type="text" name="theme_color" class="form-control jscolor" value="<?php echo $result['theme_color']; ?>">
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