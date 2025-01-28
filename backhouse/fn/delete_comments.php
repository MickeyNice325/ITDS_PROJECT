<?php
include('config.php');

// ตรวจสอบว่าได้ส่งข้อมูลคอมเมนต์ที่ต้องการลบหรือไม่
if (isset($_POST['comments']) && !empty($_POST['comments'])) {
    // ดึงค่าจากฟอร์มที่เลือกคอมเมนต์
    $comments_to_delete = $_POST['comments'];

    // สร้างคำสั่ง SQL เพื่อลบคอมเมนต์ที่เลือก
    $comment_times = implode("','", $comments_to_delete);
    $sql = "DELETE FROM comment_tb WHERE time IN ('$comment_times')";

    // ดำเนินการลบ
    if ($conn->query($sql) === TRUE) {
        // หากลบสำเร็จ, แสดงข้อความแจ้งเตือนและเปลี่ยนหน้า
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js'></script>
              <script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบคอมเมนต์สำเร็จ',
                        text: 'คอมเมนต์ที่เลือกถูกลบออกจากฐานข้อมูลแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '../commentsedit.php'; // เปลี่ยนหน้าไปที่ commentsedit.php
                    });
                }
              </script>";
    } else {
        // หากลบไม่สำเร็จ, แสดงข้อความแจ้งเตือนและเปลี่ยนหน้า
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js'></script>
              <script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถลบคอมเมนต์ได้',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '../commentsedit.php'; // เปลี่ยนหน้าไปที่ commentsedit.php
                    });
                }
              </script>";
    }
} else {
    // หากไม่มีการเลือกคอมเมนต์
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js'></script>
          <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่มีคอมเมนต์ที่เลือก',
                    text: 'กรุณาเลือกคอมเมนต์ที่ต้องการลบ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '../commentsedit.php'; // เปลี่ยนหน้าไปที่ commentsedit.php
                });
            }
          </script>";
}

$conn->close();
?>
