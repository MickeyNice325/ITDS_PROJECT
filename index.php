<?php
include("backhouse/fn/config.php");
$sql = "SELECT name, message FROM comment_tb";
$result = $conn->query($sql);
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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="news-grid">
            <?php include("show_news.php") ?>
        </div>
        <div class="chat">
            <div class="chat-header">COMMENT</div>
            <div class="chat-messages" id="chat-messages">
           
            </div>
        </div>
        <div class="news-ticker">
            <div class="ticker-content">
                <?php foreach ($news_items as $news): ?>
                    <div class="ticker-item">
                        <?php echo htmlspecialchars($news['news_detail']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="floating-image" id="floating-image">
        <img src="backhouse/img/qr/qr.png" alt="Floating Image">
    </div>

    <script>

    

function fetchComments() {
    fetch('get_comments.php') // ดึงคอมเมนต์จาก PHP
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Received content is not JSON');
        }
        return response.json();
    })
    .then(data => {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.innerHTML = ''; // ล้างข้อความเก่า

        // แสดงคอมเมนต์ใหม่
        data.forEach(comment => {
            const message = comment.message;
            chatMessages.innerHTML += `<h3><strong>${comment.name}:</strong> ${message}</h3>`;
        });

        // เลื่อนให้แสดงคอมเมนต์ใหม่ที่ด้านล่าง
        chatMessages.scrollTop = chatMessages.scrollHeight;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}

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