<?php include 'layouts/top.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form_change_status'])) {
    $statement = $pdo->prepare("SELECT * FROM comments WHERE id=?");
    $statement->execute([$_POST['comment_id']]);
    $comment_data = $statement->fetch(PDO::FETCH_ASSOC);
    $current_status = $comment_data['status'];
    if($current_status == 'Pending') {
        $new_status = 'Approved';
    } else {
        $new_status = 'Pending';
    }
    $statement = $pdo->prepare("UPDATE comments SET status=? WHERE id=?");
    $statement->execute([$new_status, $_POST['comment_id']]);

    $statement = $pdo->prepare("SELECT * FROM posts WHERE id=?");
    $statement->execute([$comment_data['post_id']]);
    $post_data = $statement->fetch(PDO::FETCH_ASSOC);

    $email_message = "Your comment has been approved. You can see your comment on the post. <br>";
    $email_message .= "<a href='".BASE_URL."post/".$post_data['slug']."'>View Post</a>";

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_ENCRYPTION;
    $mail->Port = SMTP_PORT;
    $mail->setFrom(SMTP_FROM);
    $mail->addAddress($comment_data['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Your Comment Status Changed';
    $mail->Body = $email_message;
    $mail->send();

    $_SESSION['success_message'] = 'Comment status changed successfully.';
    header('location: '.ADMIN_URL.'comment-view.php');
    exit;
}
?>

<?php
if(isset($_POST['form_change_reply_status'])) {
    $statement = $pdo->prepare("SELECT * FROM replies WHERE id=?");
    $statement->execute([$_POST['reply_id']]);
    $reply_data = $statement->fetch(PDO::FETCH_ASSOC);
    $current_status = $reply_data['status'];
    if($current_status == 'Pending') {
        $new_status = 'Approved';
    } else {
        $new_status = 'Pending';
    }
    $statement = $pdo->prepare("UPDATE replies SET status=? WHERE id=?");
    $statement->execute([$new_status, $_POST['reply_id']]);

    $statement = $pdo->prepare("SELECT * FROM posts WHERE id=?");
    $statement->execute([$reply_data['post_id']]);
    $post_data = $statement->fetch(PDO::FETCH_ASSOC);

    $email_message = "Your reply has been approved. You can see your reply on the post. <br>";
    $email_message .= "<a href='".BASE_URL."post/".$post_data['slug']."'>View Post</a>";

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_ENCRYPTION;
    $mail->Port = SMTP_PORT;
    $mail->setFrom(SMTP_FROM);
    $mail->addAddress($reply_data['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Your Reply Status Changed';
    $mail->Body = $email_message;
    $mail->send();

    $_SESSION['success_message'] = 'Reply status changed successfully.';
    header('location: '.ADMIN_URL.'comment-view.php');
    exit;
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>All Comments</h1>
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
                                            <th>Post</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Content</th>
                                            <th>Publish Date</th>
                                            <th>Status</th>
                                            <th>Change</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT c.*,
                                                            p.title AS post_title 
                                                            FROM comments c
                                                            JOIN posts p
                                                            ON c.post_id = p.id ORDER BY c.id DESC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['post_title']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <?php echo $row['content']; ?><br>
                                                    <a href="javascript:void;" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $i; ?>">Reply</a>
                                                </td>
                                                <!-- Modal -->
                                                <div class="modal fade" id="replyModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">All Replies</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                    $j=0;
                                                                    $statement1 = $pdo->prepare("SELECT * FROM replies WHERE comment_id=?");
                                                                    $statement1->execute([$row['id']]);
                                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result1 as $row1) {
                                                                        $j++;
                                                                        ?>
                                                                        <strong>Reply #<?php echo $j; ?></strong><br>
                                                                        Name: <?php echo $row1['name']; ?><br>
                                                                        Email: <?php echo $row1['email']; ?><br>
                                                                        Content: <?php echo $row1['content']; ?><br>
                                                                        Publish Date: <?php echo $row1['publish_date']; ?><br>
                                                                        Status: 
                                                                        <?php if($row1['status'] == 'Pending'): ?>
                                                                        <span class="text-danger"><?php echo $row1['status']; ?></span>
                                                                        <?php elseif($row1['status'] == 'Approved'): ?>
                                                                        <span class="text-success"><?php echo $row1['status']; ?></span>
                                                                        <?php endif; ?>

                                                                        <form action="" method="post">
                                                                        <input type="hidden" name="reply_id" value="<?php echo $row1['id']; ?>">
                                                                        <button type="submit" class="btn btn-warning btn-sm" name="form_change_reply_status">
                                                                            Change
                                                                        </button>
                                                                        </form>

                                                                        <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <td><?php echo $row['publish_date']; ?></td>
                                                <td>
                                                    <?php if($row['status'] == 'Pending'): ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                    <?php elseif($row['status'] == 'Approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <form action="" method="post">
                                                    <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm" name="form_change_status">Change</button>
                                                    </form>
                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>comment-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>comment-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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