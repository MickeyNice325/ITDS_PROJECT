<?php
include("../backhouse/fn/config.php");
header('Content-Type: application/json');

// คำหยาบที่ต้องการตรวจสอบ
$bad_words = array('ควย', 'หี', 'แตด', 'มึง', 'มิง', 'มีง', 'มืง', 'กู', 'กุ', 'ตาย', 'kuy', 'เหีย', 'ลูกหรี่', 'เย็ด', 'fuck', 'ไอ่', 'skibidi', 'sigma', 'mewing', 'สมองหาย', 'ควาย', 'กระบือ', 'fuxk', 'fxck', 'fucx', 'โง่', 'กาก', 'ดักดาน', 'ไม่สั่งสอน', 'ไอ้', 'ควัย', 'ขวย', 'ฆวย', 'kวย', 'stupid', 'กรู', 'gu', 'เน้ด', 'เง่น', 'เงี่ยน', 'เสว', 'เสียว', 'งัว', 'suck', 'lick', 'balls', 'ตีน', 'hee', 'doujin', 'xxx', 'โป๊', 'porn', 'shit', 'noob', 'ตี๋หิด', 'ขวัย', 'ฆวัย', 'หนมน้า', 'ปัญญาอ่อน', 'ซู่หลิ่ง', 'เซ็ตหย่อ', 'ซี่หลุ่ง', 'ตูด', 'รูขี้','ไม่เล็กนะครับ', 'กระเจี๊ยว', 'กะเจี๋ยว','เกย์','gay');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    $name = htmlspecialchars(trim($data["name"] ?? ''));
    $message = htmlspecialchars(trim($data["message"] ?? ''));

    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Database connection failed"]);
        exit();
    }

    if (mb_strlen($message, 'UTF-8') > 50) {
        echo json_encode(["status" => "error", "message" => "ข้อความมากกว่า 50 ตัว"]);
        exit();
    }

    $count_sql = "SELECT COUNT(*) AS num_comments FROM comment_tb";
    $count_result = $conn->query($count_sql);
    if ($count_result) {
        $count_row = $count_result->fetch_assoc();
        if ($count_row['num_comments'] >= 30) {
            $deleteSql = "DELETE FROM comment_tb ORDER BY time ASC LIMIT 1";
            $conn->query($deleteSql);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error fetching comment count"]);
        exit();
    }

    $time = date('H:i:s');
    $date = date('Y-m-d'); // เพิ่มวันที่
    $clean_message = preg_replace('/[\s\.\+\-\ุ\ู]/', '', $message);
    $clean_name = preg_replace('/[\s\.\+\-\ุ\ู]/', '', $name);

    $contains_bad_word = false;
    foreach ($bad_words as $bad_word) {
        if (stripos($message, $bad_word) !== false || stripos($name, $bad_word) !== false) {
            $contains_bad_word = true;
            break;
        }
    }

    if ($contains_bad_word) {
        echo json_encode(["status" => "badword"]);
        exit();
    }

    $sql = "INSERT INTO comment_tb (date, time, name, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $date, $time, $name, $message);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
