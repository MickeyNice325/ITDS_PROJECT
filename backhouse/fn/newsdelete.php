<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // ใช้การเตรียมคำสั่ง (Prepared Statements)
    $sql = "DELETE FROM news_tb WHERE news_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../add_news.php?status=Deletedsuccess");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../add_news.php?status=error");
            exit;
        }
    } else {
        mysqli_close($conn);
        header("Location: ../add_news.php?status=error");
        exit;
    }
} else {
    header("Location: ../add_news.php?status=Deletednotfound");
    exit;
}
?>
