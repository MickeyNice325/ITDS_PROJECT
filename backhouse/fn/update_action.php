<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    echo "ข้อมูลได้รับการอัพเดทแล้ว!";

    header("Refresh: 2; url=../../index.php"); 
    exit;
}
?>
