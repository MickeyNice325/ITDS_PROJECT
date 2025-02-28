<?php
include("backhouse/fn/config.php");

$query = "SELECT comments_enabled FROM settings LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo json_encode(["comments_enabled" => (int) $row['comments_enabled']]);
?>
