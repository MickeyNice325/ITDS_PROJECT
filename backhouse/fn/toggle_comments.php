<?php
require 'config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ดึงค่าสถานะปัจจุบันจากตาราง settings
$query = "SELECT comments_enabled FROM settings LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_status = (int) $row['comments_enabled']; // แปลงเป็น int เพื่อความแน่นอน

    // สลับค่า (0 เป็น 1, 1 เป็น 0)
    $new_status = ($current_status === 1) ? 0 : 1;

    // อัปเดตค่าในฐานข้อมูล
    $updateQuery = "UPDATE settings SET comments_enabled='$new_status'";
    if ($conn->query($updateQuery)) {
        // กำหนดข้อความแจ้งเตือนตามสถานะใหม่
        $message = ($new_status === 1) ? "เปิดคอมเมนต์เรียบร้อยแล้ว" : "ปิดคอมเมนต์เรียบร้อยแล้ว";

        // ใช้ JavaScript เพื่อโหลด SweetAlert2 ให้แน่ใจว่า DOM โหลดเสร็จก่อน
        echo "<html><head>";
        echo "<link href='https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap' rel='stylesheet'>";  // เพิ่มฟอนต์
        echo "<link href='../css/bg.css' rel='stylesheet'>";  // เพิ่มฟอนต์
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "</head><body>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: '$message',
                    icon: 'success',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.replace('../commentsedit.php');
                });
            });
        </script>";
        echo "</body></html>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ไม่พบข้อมูล settings'); window.history.back();</script>";
}

$conn->close();
?>
