<?php
include("../backhouse/fn/config.php");
header('Content-Type: application/json');

// คำหยาบที่ต้องการตรวจสอบ
$bad_words = array('ควย', 'หี', 'แตด', 'มึง', 'กู', 'ตาย', 'kuy', 'เหีย', 
'ลูกหรี่', 'เย็ด', 'fuck', 'ไอ่', 'skibidi', 'sigma', 'mewing'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    $name = htmlspecialchars(trim($data["name"]));
    $message = htmlspecialchars(trim($data["message"]));

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Database connection failed"]);
        exit();
    }

    // ตรวจสอบความยาวของข้อความ
    if (mb_strlen($message, 'UTF-8') > 20) { // ใช้ mb_strlen สำหรับข้อความทั้งหมด
        echo json_encode(["status" => "error", "message" => "ข้อความมากกว่า 20 ตัว"]);
        exit();
    }

    // นับจำนวนคอมเมนต์ในฐานข้อมูล
    $count_sql = "SELECT COUNT(*) AS num_comments FROM comment_tb";
    $count_result = $conn->query($count_sql);
    $count_row = $count_result->fetch_assoc();
    
    if ($count_row['num_comments'] >= 20) {
        $deleteSql = "DELETE FROM comment_tb ORDER BY time ASC LIMIT 1";
        $conn->query($deleteSql);
    }

    $time = date('H:i:s');

    // ตรวจสอบคำหยาบ
    $contains_bad_word = false;
    foreach ($bad_words as $bad_word) {
        if (stripos($message, $bad_word) !== false || stripos($name, $bad_word) !== false) {
            $contains_bad_word = true;
            break;
        }
    }

    // ถ้ามีคำหยาบ ให้ส่งข้อความกลับ
    if ($contains_bad_word) {
        echo json_encode(["status" => "badword"]);
        exit();
    }

    // บันทึกคอมเมนต์
    $sql = "INSERT INTO comment_tb (time, name, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $time, $name, $message);

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
