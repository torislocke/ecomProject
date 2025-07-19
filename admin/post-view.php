<?php include 'layouts/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Posts</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>post-create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT p.*,
                                                                pc.name AS post_category_name
                                                                FROM posts p
                                                                JOIN post_categories pc 
                                                                ON p.post_category_id = pc.id
                                                                ORDER BY p.id DESC
                                                            ");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="img-fluid" style="max-width: 100px;">
                                                </td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['slug']; ?></td>
                                                <td><?php echo $row['post_category_name']; ?></td>
                                                <td><?php echo $row['tags']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>post-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>post-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>