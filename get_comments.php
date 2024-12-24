<?php
header('Content-Type: application/json');
include("backhouse/fn/config.php");

$result = $conn->query("SELECT name, message, time FROM comment_tb ORDER BY time DESC");
$comments = [];

while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode(array_reverse($comments)); // ส่งกลับในลำดับใหม่
$conn->close();
?>
