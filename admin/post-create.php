<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {

        $tag_final = '';
        if(!empty($_POST['tags'])) {
            $i=0;
            foreach($_POST['tags'] as $tag) {
                if($i == 0) {
                    $tag_final .= $tag;
                } else {
                    $tag_final .= ','.$tag;
                }
                $i++;
            }
        }

        if($_POST['title'] == '') {
            throw new Exception('Title cannot be empty');
        }
        if($_POST['slug'] == '') {
            throw new Exception('Slug cannot be empty');
        }
        if($_POST['content'] == '') {
            throw new Exception('Content cannot be empty');
        }
        if($_POST['post_category_id'] == '') {
            throw new Exception('Please select a post category');
        }

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];
        if($path=='') {
            throw new Exception('Please select a photo');
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = "post_".time().".".$extension;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            throw new Exception('Please upload a valid photo');
        }

        move_uploaded_file($path_tmp, '../uploads/'.$filename);

        $statement = $pdo->prepare("INSERT INTO posts (title, slug, content, photo, post_category_id, tags, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute([$_POST['title'], $_POST['slug'], $_POST['content'], $filename, $_POST['post_category_id'], $tag_final, date('Y-m-d'), date('Y-m-d')]);

        $_SESSION['success_message'] = 'Post has been created successfully.';
        header('location: '.ADMIN_URL.'post-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'post-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Post</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>post-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
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
                                            <label>Photo *</label>
                                            <div>
                                                <input type="file" name="photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Title *</label>
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Slug *</label>
                                            <input type="text" class="form-control" name="slug">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Category *</label>
                                            <select name="post_category_id" class="form-select">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM post_categories");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($result as $row) {
                                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Content *</label>
                                            <textarea class="form-control editor" name="content" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Tags</label>
                                            <select name="tags[]" class="form-select select_multiple" multiple="multiple"></select>
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