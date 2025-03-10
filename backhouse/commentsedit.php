<?php
include('nav.php');
include('fn/config.php');

// ดึงข้อมูลคอมเมนต์จากฐานข้อมูล
$sql1 = "SELECT * FROM comment_tb ORDER BY time DESC";
$result_comments = $conn->query($sql1);

$sql2 = "SELECT comments_enabled FROM settings LIMIT 1";
$result_settings = mysqli_query($conn, $sql2);
$row = mysqli_fetch_assoc($result_settings);


// ตรวจสอบค่าของ comments_enabled
$comment_status = $row['comments_enabled'];

$button_text = ($comment_status == 1) ? "ปิดคอมเมนต์" : "เปิดคอมเมนต์";
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขคอมเมนต์</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bg.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/ico" href="img/icon.ico"/>
</head>
<body>
<div class="container mt-5">
    <a class="btn btn-outline-dark" href="fn/toggle_comments.php" id="toggleComments">
        <?= $button_text ?>
    </a>
    <h2>คอมเมนต์ล่าสุด</h2>
    <form method="POST" action="fn/delete_comments.php" id="delete_form">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all"> เลือกทั้งหมด</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>ข้อความคอมเมนต์</th>
                    <th>ชื่อผู้เขียน</th>
                </tr>
            </thead>
            <tbody>
    <?php
    // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
    if ($result_comments->num_rows > 0) {
        // แสดงผลข้อมูลแต่ละแถว
        while($row = $result_comments->fetch_assoc()) {
            echo "<tr>
                <td><input type='checkbox' name='comments[]' value='" . $row["time"] . "'></td>
                <td>" . $row["date"] . "</td>
                <td>" . $row["time"] . "</td>
                <td>" . $row["message"] . "</td>
                <td>" . $row["name"] . "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>ไม่พบข้อมูลคอมเมนต์</td></tr>";
    }
    ?>
</tbody>

        </table>
        <button type="button" class="btn btn-danger" id="delete_btn">ลบคอมเมนต์ที่เลือก</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    // สคริปต์เลือกทั้งหมด
    document.getElementById('select_all').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="comments[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // ใช้ SweetAlert2 สำหรับการยืนยันการลบ
    document.getElementById('delete_btn').addEventListener('click', function() {
        const selectedComments = document.querySelectorAll('input[name="comments[]"]:checked');
        if (selectedComments.length > 0) {
            // แสดง SweetAlert2 สำหรับการยืนยันการลบ
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณแน่ใจหรือไม่ว่าต้องการลบคอมเมนต์ที่เลือก?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // เมื่อผู้ใช้ยืนยัน, ส่งฟอร์มเพื่อดำเนินการลบ
                    document.getElementById('delete_form').submit();
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ไม่พบคอมเมนต์ที่เลือก',
                text: 'กรุณาเลือกคอมเมนต์ที่ต้องการลบ',
            });
        }
    });
</script>
</body>
</html>
