<?php
include '../config/config.php';
$statement = $pdo->prepare("SELECT * FROM subscribers WHERE status=?");
$statement->execute(['Active']);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="subscribers_'.time().'.csv"');
$output = fopen('php://output', 'w');
fputcsv($output, ['id','Email']);
foreach ($result as $row) {
    fputcsv($output, [$row['id'],$row['email']]);
}
fclose($output);
exit;