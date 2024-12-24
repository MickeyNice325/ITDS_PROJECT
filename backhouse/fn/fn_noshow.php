<?php

include('config.php');

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    
    $sql = "UPDATE news_tb SET news_stats = 'noshow' WHERE news_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $news_id); // ผูกตัวแปร news_id กับ statement

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location: ../add_news.php?status=noshowsuccess");
        exit;
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location: ../add_news.php?status=error");
        exit;
    }
} else {
    header("Location: ../add_news.php?status=error");
    exit;
}
?>
