<?php
require 'fn/config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ดึงค่าสถานะปัจจุบันของ comments_enabled
$query = "SELECT comments_enabled FROM settings LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$comments_enabled = (int) $row['comments_enabled']; // แปลงเป็น int
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="add_news.php">เพิ่มข่าว</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add_img.php">เพิ่มรูป</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="commentsedit.php">แก้ไขคอมเมนต์</a>
        </li>
      </ul>
    </div>
  </div>
</nav>



