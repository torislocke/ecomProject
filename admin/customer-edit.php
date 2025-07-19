<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM customers WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'customer-view.php');
    exit;
}
?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception('Name can not be empty');
        }
        if($_POST['email'] == '') {
            throw new Exception('Email can not be empty');
        }
        // email validation check
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is not valid');
        }
        // duplicate email check
        $statement = $pdo->prepare("SELECT * FROM customers WHERE email=? AND id!=?");
        $statement->execute([$_POST['email'], $_REQUEST['id']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception('Email already exists');
        }
        if($_POST['phone'] == '') {
            throw new Exception('Phone can not be empty');
        }
        if($_POST['address'] == '') {
            throw new Exception('Address can not be empty');
        }

        if($_POST['password'] != '') {
            if($_POST['confirm_password'] == '') {
                throw new Exception('Confirm Password can not be empty');
            }
            if($_POST['password'] != $_POST['confirm_password']) {
                throw new Exception('Passwords do not match');
            }
            $final_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $statement = $pdo->prepare("UPDATE customers SET name=?, email=?, phone=?, address=?, password=?, status=? WHERE id=?");
        $statement->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            isset($final_password) ? $final_password : $result['password'],
            $_POST['status'],
            $_REQUEST['id']
        ]);

        $_SESSION['success_message'] = 'Customer has been updated successfully.';
        header('location: '.ADMIN_URL.'customer-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'customer-edit.php?id='.$_REQUEST['id']);
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM customers WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Customer</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>customer-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Email *</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $result['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $result['phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Address *</label>
                                            <input type="text" class="form-control" name="address" value="<?php echo $result['address']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Status *</label>
                                            <select name="status" class="form-select">
                                                <option value="Active" <?php if($result['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                                <option value="Inactive" <?php if($result['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
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