<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $news_id = $_POST['news_id'];
    $news_name = $_POST['news_name'];
    $news_detail = $_POST['news_detail'];
    $news_delay = $_POST['news_delay'];

    $sql = "UPDATE news_tb SET news_name = ?, news_detail = ?, news_delay = ? WHERE news_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdi', $news_name, $news_detail, $news_delay, $news_id);

    if ($stmt->execute()) {
        header("Location: ../add_news.php?status=editsuccess");
    } else {
        header("Location: ../add_news.php?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>
