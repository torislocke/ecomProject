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
        // Slug validation using regex
        if(!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $_POST['slug'])) {
            throw new Exception('Slug can only contain lowercase letters, numbers, and hyphens');
        }
        // Slug uniqueness using database check
        $statement = $pdo->prepare("SELECT * FROM products WHERE slug=?");
        $statement->execute([$_POST['slug']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception('Slug already exists');
        }
        if($_POST['quantity'] == '') {
            throw new Exception('Quantity cannot be empty');
        }
        // numeric validation for quantity
        if(!is_numeric($_POST['quantity'])) {
            throw new Exception('Quantity must be a number');
        }
        if($_POST['regular_price'] == '') {
            throw new Exception('Regular Price cannot be empty');
        }
        if(!is_numeric($_POST['regular_price'])) {
            throw new Exception('Regular Price must be a number');
        }
        if($_POST['sale_price'] == '') {
            throw new Exception('Sale Price cannot be empty');
        }
        if(!is_numeric($_POST['sale_price'])) {
            throw new Exception('Sale Price must be a number');
        }
        if($_POST['sale_price'] > $_POST['regular_price']) {
            throw new Exception('Sale Price cannot be greater than Regular Price');
        }
        if($_POST['short_description'] == '') {
            throw new Exception('Short Description cannot be empty');
        }
        if($_POST['description'] == '') {
            throw new Exception('Description cannot be empty');
        }

        $path = $_FILES['featured_photo']['name'];
        $path_tmp = $_FILES['featured_photo']['tmp_name'];

        if($path=='') {
            throw new Exception('Please select a photo');
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = "product_".time().".".$extension;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            throw new Exception('Please upload a valid photo');
        }

        $source = $path_tmp;
        $destination = '../uploads/'.$filename;
        image_resize($source, $destination, 420, 500);

        $statement = $pdo->prepare("INSERT INTO products (featured_photo, name, slug, product_category_id, quantity, regular_price, sale_price, short_description, description, sku, size, color, capacity, weight, pocket, water_resistant, warranty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute([$filename,$_POST['name'],$_POST['slug'],$_POST['product_category_id'],$_POST['quantity'],$_POST['regular_price'],$_POST['sale_price'],$_POST['short_description'],$_POST['description'],$_POST['sku'],$_POST['size'],$_POST['color'],$_POST['capacity'],$_POST['weight'],$_POST['pocket'],$_POST['water_resistant'],$_POST['warranty']]);

        $_SESSION['success_message'] = 'Product has been created successfully.';
        header('location: '.ADMIN_URL.'product-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Product</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>product-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
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
                                            <label>Featured Photo *</label>
                                            <div>
                                                <input type="file" name="featured_photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Slug *</label>
                                            <input type="text" class="form-control" name="slug" value="<?php if(isset($_POST['slug'])) {echo $_POST['slug'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Select Category *</label>
                                            <select name="product_category_id" class="form-select">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM product_categories ORDER BY name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if(isset($_POST['product_category_id']) && $_POST['product_category_id'] == $row['id']) {echo 'selected';} ?>><?php echo $row['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Quantity *</label>
                                            <input type="text" class="form-control" name="quantity" value="<?php if(isset($_POST['quantity'])) {echo $_POST['quantity'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Regular Price *</label>
                                            <input type="text" class="form-control" name="regular_price" value="<?php if(isset($_POST['regular_price'])) {echo $_POST['regular_price'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Sale Price *</label>
                                            <input type="text" class="form-control" name="sale_price" value="<?php if(isset($_POST['sale_price'])) {echo $_POST['sale_price'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Short Description *</label>
                                            <textarea name="short_description" class="form-control h_100"><?php if(isset($_POST['short_description'])) {echo $_POST['short_description'];} ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Description *</label>
                                            <textarea name="description" class="form-control editor"><?php if(isset($_POST['description'])) {echo $_POST['description'];} ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>SKU</label>
                                            <input type="text" class="form-control" name="sku" value="<?php if(isset($_POST['sku'])) {echo $_POST['sku'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Size</label>
                                            <input type="text" class="form-control" name="size" value="<?php if(isset($_POST['size'])) {echo $_POST['size'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Color</label>
                                            <input type="text" class="form-control" name="color" value="<?php if(isset($_POST['color'])) {echo $_POST['color'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Capacity</label>
                                            <input type="text" class="form-control" name="capacity" value="<?php if(isset($_POST['capacity'])) {echo $_POST['capacity'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Weight</label>
                                            <input type="text" class="form-control" name="weight" value="<?php if(isset($_POST['weight'])) {echo $_POST['weight'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Pocket</label>
                                            <input type="text" class="form-control" name="pocket" value="<?php if(isset($_POST['pocket'])) {echo $_POST['pocket'];} ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Water Resistant</label>
                                            <select name="water_resistant" class="form-select">
                                                <option value="Yes" <?php if(isset($_POST['water_resistant']) && $_POST['water_resistant'] == 'Yes') {echo 'selected';} ?>>Yes</option>
                                                <option value="No" <?php if(isset($_POST['water_resistant']) && $_POST['water_resistant'] == 'No') {echo 'selected';} ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Warranty</label>
                                            <input type="text" class="form-control" name="warranty" value="<?php if(isset($_POST['warranty'])) {echo $_POST['warranty'];} ?>">
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