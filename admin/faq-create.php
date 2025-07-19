<?php include 'layouts/top.php'; ?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['question'] == '') {
            throw new Exception('Question cannot be empty');
        }

        if($_POST['answer'] == '') {
            throw new Exception('Answer cannot be empty');
        }

        $statement = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $statement->execute([$_POST['question'], $_POST['answer']]);

        $_SESSION['success_message'] = 'FAQ has been created successfully.';
        header('location: '.ADMIN_URL.'faq-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'faq-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create FAQ</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>faq-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
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
                                            <label>Question *</label>
                                            <input type="text" class="form-control" name="question">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Answer *</label>
                                            <textarea class="form-control h_200" name="answer" rows="5"></textarea>
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