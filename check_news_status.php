<?php
include("backhouse/fn/config.php");

$query = "SELECT news_stats FROM news_tb LIMIT 1";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['news_stats' => $row['news_stats']]);
} else {
    echo json_encode(['error' => 'Query failed']);
}
?>
