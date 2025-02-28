<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITDS : Comments</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/ico" href="img/icon.ico"/>
</head>
<body>
    <div class="form-container">
        <h2>พิมพ์ข้อความเพื่อแสดง</h2>
        <form id="comment-form">
            <label for="name">ชื่อ</label>
            <input type="text" id="name" name="name" required>
            
            <label for="message">ข้อความ</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            
            <button type="submit">ส่งข้อความ</button>
        </form>
        <p id="status"></p>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                title: 'ส่งข้อความแล้ว',
                text: 'ข้อความขึ้นจอภาพแล้ว',
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                window.location.search = '';
            });
        } else if (status === 'badword') {
            Swal.fire({
                title: 'ข้อความหรือชื่อไม่เหมาะสม',
                icon: 'error',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                window.location.search = '';
            });
        }
    });

    document.getElementById('comment-form').addEventListener('submit', function (e) {
        e.preventDefault(); 

        const name = document.getElementById('name').value.trim();
        const message = document.getElementById('message').value.trim();

        if (name && message) {
            fetch('submit.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: name, message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'ส่งข้อความสำเร็จ',
                        icon: 'success',
                        confirmButtonText: 'ตกลง'
                    });
                    document.getElementById('comment-form').reset(); // ล้างฟอร์ม
                } else {
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });
        }
    });
</script>
</html>
