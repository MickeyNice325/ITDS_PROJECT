<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="img/icon.ico"/>
    <title>Add News</title>
<!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
<!-- Custom CSS -->
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="css/bg.css">
<!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
<!-- Custom JS -->
    <script src="js/sweetalert2/Delete.js"></script>
    <script src="js/sweetalert2/confirm-edit.js"></script>
<!-- Include PHP files -->
    <?php
       include('nav.php');
       include('fn/config.php');

       $search = "";

       if(isset($_POST['search'])) {
           $search = $_POST['search'];
       }
    ?>
</head>
<body>
    <div class="container2">
        <form class="search-form mb-4" method="POST">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="ค้นหาด้วยชื่อ" name="search" value="<?= $search ?>">
                <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
            </div>
        </form>
    </div>

    <div class="container">
<!-- Search Form -->
        <?php  
            $sql = "SELECT * FROM img_tb WHERE img_name LIKE '%$search%'";
            $query = mysqli_query($conn, $sql);

            if(mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_array($query)){
                    $id = $row['img_id'];
                    $img_name = $row['img_name'];
                    $img_detail = $row['img_detail'];
                    $img_image = $row['imge'];
        ?>
            <div class="card">
                <img src="img/news/<?=$row['imge']?>" class="card-img-top">
                <div class="card-body">
                    <h6 class="card-title"><?=$img_name?></h6>
                    <!-- Info Button to Trigger Modal -->
                    <button type="button" class="btn btn-outline-primary w-100 mb-1" data-bs-toggle="modal" data-bs-target="#infoNewsModal<?=$id?>">
                        ข้อมูล
                    </button>
                    <!-- Edit Button -->
                    <a href="#" class="btn btn-success w-100 mb-1" data-bs-toggle="modal" data-bs-target="#editNewsModal<?=$id?>">แก้ไข</a>
                    <!-- Delete Button -->
                    <a href="fn/delete.php?id=<?php echo $id; ?>" class="delete-btn btn btn-danger w-100 mb-1">ลบ</a>
                </div>
            </div>
        <?php 
                }
            } 
        ?>
        
<!-- Add News Button -->
        <div class="card add-card">
            <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addNewsModal">+</button>
        </div>
    </div>

<!-- Edit News Modal -->
    <?php  
        $sql = "SELECT * FROM img_tb";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)){
            $id = $row['img_id'];
            $img_name = $row['img_name'];
            $img_detail = $row['img_detail'];
    ?>
    <div class="modal fade" id="editNewsModal<?=$id?>" tabindex="-1" aria-labelledby="editNewsModalLabel<?=$id?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNewsModalLabel<?=$id?>">Edit Imge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm<?=$id?>" action="fn/editimg.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="img_id" value="<?=$id?>">
                        <div class="mb-3">
                            <label for="edit_img_name<?=$id?>" class="form-label">Imge Name</label>
                            <input type="text" class="form-control" id="edit_img_name<?=$id?>" name="edit_img_name" value="<?=$img_name?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_img_detail<?=$id?>" class="form-label">Imge Detail</label>
                            <textarea class="form-control" id="edit_img_detail<?=$id?>" name="edit_img_detail" required><?=$img_detail?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="change-btn btn btn-primary">บันทึกการแก้ไข</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php } ?>

<!-- Info Modals -->
    <?php  
        $sql = "SELECT * FROM img_tb";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)){
            $id = $row['img_id'];
            $img_name = $row['img_name'];
            $img_detail = $row['img_detail'];
            $image = $row['imge'];
            $width = $row['width'];
            $height = $row['height'];
    ?>
    <div class="modal fade" id="infoNewsModal<?=$id?>" tabindex="-1" aria-labelledby="infoNewsModalLabel<?=$id?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoNewsModalLabel<?=$id?>">รูป: <?=$img_name?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="img/news/<?=$image?>" class="img-fluid" alt="News Image">
                        </div>
                        <div class="col-md-8">
                            <p><strong>ข้อมูล</strong></p>
                            <p>ขนาด : <?=$width?> x <?=$height?></p>
                            <p><?=$img_detail?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

<!-- Add img Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">เพิ่มรูป</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="fn/fn_addimg.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="img_name" class="form-label">ชื่อรูป</label>
                            <input type="text" class="form-control" id="img_name" name="img_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="img_detail" class="form-label">ข้อมูลรูป</label>
                            <textarea class="form-control" id="img_detail" name="img_detail" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imge" class="form-label">รูป</label>
                            <input type="file" class="form-control" id="imge" name="imge" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึกรูป</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- status -->
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'Deletedsuccess') {
        Swal.fire({
            title: 'ลบแล้ว',
            text: 'ไฟล์รูปภาพลบแล้ว',
            icon: 'success',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = '';
        });
    } else if (status === 'error') {
        Swal.fire({
            title: 'เกิดข้อผิดพลาด',
            text: 'มีข่าวที่ใช้รูปนี้อยู่กรุณาลบข่าวก่อน',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    } else if (status === 'Deletednotfound') {
        Swal.fire({
            title: 'หาไฟล์ไม่เจอ!',
            text: 'หาไฟล์ไม่เจอใน database.',
            icon: 'warning',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    } else if (status === 'Deletedinvalid') {
        Swal.fire({
            title: 'คำขอไม่ถูกต้อง!',
            text: 'คำขอไม่ถูกต้อง',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    }else if (status === 'Addsuccess') {
        Swal.fire({
            title: 'เพิ่มรูปเสร็จแล้ว!',
            icon: 'success',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    }else if (status === 'editsuccess') {
        Swal.fire({
            title: 'แก้ไขเสร็จแล้ว!',
            icon: 'success',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    }
});</script>
</body>
</html>
