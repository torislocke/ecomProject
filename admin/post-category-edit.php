<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM post_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'post-category-view.php');
    exit;
}
?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }

        if($_POST['slug'] == '') {
            throw new Exception('Slug cannot be empty');
        }

        $statement = $pdo->prepare("UPDATE post_categories SET name=?, slug=? WHERE id=?");
        $statement->execute([$_POST['name'], $_POST['slug'], $_REQUEST['id']]);

        $_SESSION['success_message'] = 'Post category has been updated successfully.';
        header('location: '.ADMIN_URL.'post-category-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'post-category-edit.php?id='.$_REQUEST['id']);
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM post_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Post Category</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>post-category-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
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
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Slug *</label>
                                            <input type="text" class="form-control" name="slug" value="<?php echo $result['slug']; ?>">
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