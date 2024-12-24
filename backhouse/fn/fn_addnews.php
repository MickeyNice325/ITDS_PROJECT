<?php
include('config.php');

// ตรวจสอบว่าได้รับการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $news_name = $_POST['news_name'];
    $news_detail = $_POST['news_detail'];
    $news_delay = $_POST['news_delay'];
    $layout_select = $_POST['layout_select'];

    // เตรียม ID ของรูปภาพแต่ละตัว (ถ้าไม่มีให้ใช้ NULL)
    $img_id_1 = !empty($_POST['image_id_1']) ? $_POST['image_id_1'] : NULL;
    $img_id_2 = !empty($_POST['image_id_2']) ? $_POST['image_id_2'] : NULL;
    $img_id_3 = !empty($_POST['image_id_3']) ? $_POST['image_id_3'] : NULL;
    $img_id_4 = !empty($_POST['image_id_4']) ? $_POST['image_id_4'] : NULL;
    $img_id_5 = !empty($_POST['image_id_5']) ? $_POST['image_id_5'] : NULL;

    if (empty($news_delay)) {
        header("Location: ../add_news.php?status=errordelay");
        exit(); 
    }
    if (empty($layout_select)) {
        header("Location: ../add_news.php?status=errorlayout");
        exit(); 
    }
    // เริ่มต้นการเพิ่มข้อมูลข่าวลงในฐานข้อมูล
    $sql_news = "INSERT INTO news_tb (news_name, news_detail, news_delay, layout_select, img_id_1, img_id_2, img_id_3, img_id_4, img_id_5, news_stats) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'noshow')";
    $stmt_news = $conn->prepare($sql_news);

    // ตรวจสอบข้อผิดพลาดการเตรียม statement
    if ($stmt_news === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // ผูกค่า parameter กับ statement
    $stmt_news->bind_param('sssississ', $news_name, $news_detail, $news_delay, $layout_select, $img_id_1, $img_id_2, $img_id_3, $img_id_4, $img_id_5);

    if ($stmt_news->execute()) {
        header("Location: ../add_news.php?status=Addsuccess");
    } else {
        header("Location: ../add_news.php?status=error");
    }
}
?>
