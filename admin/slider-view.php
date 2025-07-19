<?php include 'layouts/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Sliders</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>slider-create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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
                                            <th>Photo 1</th>
                                            <th>Photo 2</th>
                                            <th>Subheading</th>
                                            <th>Heading</th>
                                            <th>Button Text</th>
                                            <th>Button URL</th>
                                            <th>Text Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT * FROM sliders");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo1']; ?>" alt="" style="width: 140px;">
                                                </td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo2']; ?>" alt="" style="width: 100px;">
                                                </td>
                                                <td><?php echo $row['subheading']; ?></td>
                                                <td><?php echo $row['heading']; ?></td>
                                                <td><?php echo $row['button_text']; ?></td>
                                                <td><?php echo $row['button_url']; ?></td>
                                                <td><?php echo $row['text_position']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>slider-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>slider-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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