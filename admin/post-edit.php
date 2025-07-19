<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'post-view.php');
    exit;
}
?>

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
            $filename = $result['photo']; // If no new photo is uploaded, keep the existing one
        } else {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = "post_".time().".".$extension;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
            if($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
                throw new Exception('Please upload a valid photo');
            }
            unlink('../uploads/'.$result['photo']); // Delete the old photo
            move_uploaded_file($path_tmp, '../uploads/'.$filename);
        }

        $statement = $pdo->prepare("UPDATE posts SET title=?, slug=?, content=?, post_category_id=?, tags=?, photo=? WHERE id=?");
        $statement->execute([$_POST['title'], $_POST['slug'], $_POST['content'], $_POST['post_category_id'], $tag_final, $filename, $_REQUEST['id']]);

        $_SESSION['success_message'] = 'Post has been updated successfully.';
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

<?php
$statement = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Post</h1>
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
                                            <label>Existing Photo</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['photo']; ?>" alt="" style="width: 140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Photo</label>
                                            <div>
                                                <input type="file" name="photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Title *</label>
                                            <input type="text" class="form-control" name="title" value="<?php echo $result['title']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Slug *</label>
                                            <input type="text" class="form-control" name="slug" value="<?php echo $result['slug']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Category *</label>
                                            <select name="post_category_id" class="form-select">
                                                <?php
                                                $statement1 = $pdo->prepare("SELECT * FROM post_categories");
                                                $statement1->execute();
                                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($result1 as $row1) {
                                                    ?>
                                                    <option value="<?php echo $row1['id']; ?>" <?php if($row1['id'] == $result['post_category_id']) { echo 'selected'; } ?>><?php echo $row1['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Content *</label>
                                            <textarea class="form-control editor" name="content" rows="5"><?php echo $result['content']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Tags</label>
                                            <select name="tags[]" class="form-select select_multiple" multiple="multiple">
                                                <?php
                                                $tags_arr = explode(',', $result['tags']);
                                                ?>
                                                <?php
                                                for($i=0; $i<count($tags_arr); $i++) {
                                                    ?>
                                                    <option value="<?php echo $tags_arr[$i]; ?>" selected><?php echo $tags_arr[$i]; ?></option>
                                                    <?php
                                                }
                                                ?>
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