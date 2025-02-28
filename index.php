<?php
include("backhouse/fn/config.php");
$sql = "SELECT name, message FROM comment_tb";
$result = $conn->query($sql);

// ดึงค่าการเปิด/ปิดคอมเมนต์จากตาราง settings
$query = "SELECT comments_enabled FROM settings LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$comments_enabled = (int) $row['comments_enabled'];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_news_real.css">
    <link rel="stylesheet" href="css/qr.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="css/index.css" rel="stylesheet">
    <link rel="icon" type="image/ico" href="img/icon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
</head>
<style>
        /* ปิด justify-content และ overflow ถ้าเป็น 0 */
        .news-grid.hidden-style {
            justify-content: unset !important;
            overflow: unset !important;
        }
    </style>
<body>
<div class="container">
        <div class="news-grid">
            <?php include("show_news.php") ?>
        </div>

        <?php if ($comments_enabled == 1) : ?> 
        <div class="chat">
            <div class="chat-header">COMMENT</div>
            <div class="chat-messages" id="chat-messages"></div>
            
            <div class="floating-image" id="floating-image">
                <img src="backhouse/img/qr/qr.png" alt="Floating Image">
            </div>
        </div>
        <?php endif; ?> 

    </div>

    <script>
let lastNewsStats = null; // เก็บค่าล่าสุดของ news_stats

function checkNewsStatus() {
    fetch('check_news_status.php')
        .then(response => response.json())
        .then(data => {
            if (data.news_stats !== undefined) {
                if (lastNewsStats !== null && data.news_stats !== lastNewsStats) {
                    location.reload(); // รีโหลดหน้าเมื่อค่ามีการเปลี่ยนแปลง
                }
                lastNewsStats = data.news_stats; // อัปเดตค่าล่าสุด
            }
        })
        .catch(error => console.error('Error fetching news status:', error));
}

// ตรวจสอบค่า news_stats ทุก ๆ 5 วินาที
setInterval(checkNewsStatus, 5000);
</script>



    <script>
        
        let lastCommentsEnabled = <?php echo $comments_enabled; ?>; // เก็บค่าเริ่มต้นจาก PHP

function checkCommentsStatus() {
    fetch('check_comments_status.php')
        .then(response => response.json())
        .then(data => {
            if (data.comments_enabled !== lastCommentsEnabled) {
                location.reload(); // รีโหลดหน้าเมื่อค่ามีการเปลี่ยนแปลง
            }
        })
        .catch(error => console.error('Error fetching comments status:', error));
}

// ตรวจสอบค่า settings ทุก ๆ 5 วินาที
setInterval(checkCommentsStatus, 5000);

    // รับค่า comments_enabled จาก PHP
    let commentsEnabled = <?php echo $comments_enabled; ?>;

    document.addEventListener("DOMContentLoaded", function() {
        if (commentsEnabled === 0) {
            let chatSection = document.getElementById('chat-section');
            let floatingImage = document.getElementById('floating-image');
            let newsGrid = document.querySelector('.news-grid');

            if (chatSection) chatSection.style.display = 'none';
            if (floatingImage) floatingImage.style.display = 'none';
            if (newsGrid) {
                newsGrid.style.justifyContent = 'unset';
                newsGrid.style.overflow = 'unset';
            }
        }
    });

    function fetchComments() {
        fetch('get_comments.php')
        .then(response => response.json())
        .then(data => {
            const chatMessages = document.getElementById('chat-messages');
            if (!chatMessages) return;

            chatMessages.innerHTML = '';

            data.forEach(comment => {
                chatMessages.innerHTML += `<h3><strong>${comment.name}:</strong> ${comment.message}</h3>`;
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => console.error('Error:', error));
    }

    <?php if ($comments_enabled == 1) : ?>
    document.addEventListener("DOMContentLoaded", function() {
        fetchComments();
        setInterval(fetchComments, 2000);
        setInterval(() => {
            document.getElementById('floating-image').classList.toggle('hidden');
        }, 5000);
    });
    <?php endif; ?>

// เรียกใช้ฟังก์ชันเมื่อหน้าโหลด
window.onload = function() {
    fetchComments(); // เรียกใช้เมื่อโหลดหน้า
};

setInterval(fetchComments, 2000); // อัปเดตข้อความใหม่ทุก 2 วินาที



    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();

        if (message) {
            fetch('../comment/submit.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: 'User', message: message }) // แก้ไขตามต้องการ
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    input.value = ''; 
                    fetchComments(); 
                } else {
                    alert('เกิดข้อผิดพลาด: ' + data.message);
                }
            });
        }
    }

    function toggleFloatingImage() {
        const floatingImage = document.getElementById('floating-image');
        floatingImage.classList.toggle('hidden');
    }

    // ฟังก์ชันแสดงข่าว
    function displayNews(index) {
        const layout1 = document.querySelector('#grid1');
        const layout2 = document.querySelector('#grid2');

        const currentLayout = index % 2 === 0 ? layout1 : layout2;
        const nextLayout = index % 2 === 0 ? layout2 : layout1;

        const news = newsItems[index];
        currentLayout.style.opacity = 0;
        nextLayout.className = `grid layout-${news.layout_select}`;
        nextLayout.innerHTML = '';

        for (let i = 1; i <= 5; i++) {
        if (news[`img_${i}`]) {
            const imgDiv = document.createElement('div');
            const imgElement = document.createElement('img');
            
            imgElement.classList.add('news-image');

            imgElement.src = `backhouse/img/news/${news[`img_${i}`]}`;
            imgElement.alt = "Image";

            imgDiv.appendChild(imgElement);
            nextLayout.appendChild(imgDiv);
        }
    }


        currentLayout.style.zIndex = 1;
        nextLayout.style.zIndex = 2;
        nextLayout.style.opacity = 1;

        setTimeout(() => {
            currentIndex = (currentIndex + 1) % newsItems.length;
            displayNews(currentIndex);
        }, news.news_delay * 1000);
    }

    window.onload = function() {
        displayNews(currentIndex);
        fetchComments(); // เรียกใช้ทันทีเมื่อโหลดหน้า
    };

    setInterval(fetchComments, 2000); // อัปเดตข้อความใหม่ทุก 2 วินาที
    setInterval(toggleFloatingImage, 5000); // เรียกใช้ทุก 5 วินาที
</script>



</body>

</html>