<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }

        if($_POST['slug'] == '') {
            throw new Exception('Slug cannot be empty');
        }
        
        $statement = $pdo->prepare("INSERT INTO post_categories (name,slug) VALUES (?, ?)");
        $statement->execute([$_POST['name'],$_POST['slug']]);

        $_SESSION['success_message'] = 'Post category has been created successfully.';
        header('location: '.ADMIN_URL.'post-category-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'post-category-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Post Category</h1>
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
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Slug *</label>
                                            <input type="text" class="form-control" name="slug">
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