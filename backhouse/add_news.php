<?php
include('nav.php');
include('fn/config.php');

$images = [];
$sql = "SELECT * FROM img_tb";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $images[] = $row;
    }
}

function getImageFileName($img_id, $conn) {
    if (empty($img_id)) {
        return ''; // ถ้าไม่มี img_id ให้คืนค่าว่าง
    }

    $sql = "SELECT imge FROM img_tb WHERE img_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $img_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row ? $row['imge'] : ''; 
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข่าว</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="css/bg.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

    <div class="container mt-4">
    <?php  
        $sql = "SELECT * FROM news_tb ";
        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)){
                $news_id = $row['news_id'];
                $news_name = $row['news_name'];
                $news_detail = $row['news_detail'];
                $layout_select = $row['layout_select'];
                $img_id_1 = $row['img_id_1'];
                $img_id_2 = $row['img_id_2'];
                $img_id_3 = $row['img_id_3'];
                $img_id_4 = $row['img_id_4'];
                $img_id_5 = $row['img_id_5'];
                $news_stats = $row['news_stats'];
                // ดึงข้อมูลชื่อไฟล์รูปภาพ
                $img_1 = getImageFileName($img_id_1, $conn);
                $img_2 = getImageFileName($img_id_2, $conn);
                $img_3 = getImageFileName($img_id_3, $conn);
                $img_4 = getImageFileName($img_id_4, $conn);
                $img_5 = getImageFileName($img_id_5, $conn);
    ?>
        <div class="card mb-3">
            <div class="grid layout-<?=$layout_select?>card">
                <?php if($layout_select == 1) { ?>
                    <div>
                    <?php if($img_1) { ?>
                            <img src="img/news/<?=$img_1?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <img src="img/placeholder.png" class="card-img-top-small" alt="No Image Available">
                        <?php } ?>
                    </div>
                <?php } else if($layout_select == 2) { ?>
                    <div>
                        <?php if($img_1) { ?>
                            <img src="img/news/<?=$img_1?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_2) { ?>
                            <img src="img/news/<?=$img_2?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_3) { ?>
                            <img src="img/news/<?=$img_3?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_4) { ?>
                            <img src="img/news/<?=$img_4?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                <?php } else if($layout_select == 3) { ?>
                    <div>
                        <?php if($img_1) { ?>
                            <img src="img/news/<?=$img_1?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_2) { ?>
                            <img src="img/news/<?=$img_2?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                <?php } else if($layout_select == 4) { ?>
                    <div>
                        <?php if($img_1) { ?>
                            <img src="img/news/<?=$img_1?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_2) { ?>
                            <img src="img/news/<?=$img_2?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                <?php } else if($layout_select == 5) { ?>
                    <div>
                        <?php if($img_1) { ?>
                            <img src="img/news/<?=$img_1?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_2) { ?>
                            <img src="img/news/<?=$img_2?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if($img_3) { ?>
                            <img src="img/news/<?=$img_3?>" class="card-img-top-small" alt="Image">
                        <?php } else { ?>
                            <div>ข้อมูลขาดหาย</div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <h6 class="card-title"><?=$news_name?></h6>
                <button type="button" class="btn btn-outline-primary w-100 mb-1" data-bs-toggle="modal" data-bs-target="#infoNewsModal<?=$news_id?>">
                    ข้อมูล
                </button>
                <?php if($news_stats == 'show'){ ?>
                    <a href="fn/fn_noshow.php?id=<?php echo $news_id; ?>" class="btn btn-outline-danger w-100 mb-1">ปิดแสดงผลหน้าจอ</a>
                <?php }else{ ?>
                    <a href="fn/fn_show.php?id=<?php echo $news_id; ?>" class="btn btn-outline-success w-100 mb-1">แสดงผลหน้าจอ</a>
                <?php } ?>
                <a href="#" class="btn btn-success w-100 mb-1" data-bs-toggle="modal" data-bs-target="#editNewsModal<?=$news_id?>">แก้ไข</a>

                <a href="#" class="delete-btn btn btn-danger w-100 mb-1" onclick="confirmDelete(<?=$news_id?>)">ลบ</a>

                    <script>
                    function confirmDelete(newsId) {
                        Swal.fire({
                            title: 'คุณแน่ใจหรือไม่?',
                            text: "คุณไม่สามารถย้อนกลับการกระทำนี้ได้!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่, ลบเลย!',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'fn/newsdelete.php?id=' + newsId;
                            }
                        });
                    }
                    </script>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="infoNewsModal<?=$news_id?>" tabindex="-1" aria-labelledby="infoNewsModalLabel<?=$news_id?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoNewsModalLabel<?=$news_id?>">ข้อมูลข่าว <?= $news_name; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="grid layout-<?=$layout_select?>">
                                <?php if($layout_select == 1) { ?>
                                    <div>
                                        <?php if($img_1) { ?>
                                            <img src="img/news/<?=$img_1?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                <?php } else if($layout_select == 2) { ?>
                                    <div>
                                        <?php if($img_1) { ?>
                                            <img src="img/news/<?=$img_1?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_2) { ?>
                                            <img src="img/news/<?=$img_2?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_3) { ?>
                                            <img src="img/news/<?=$img_3?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_4) { ?>
                                            <img src="img/news/<?=$img_4?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                <?php } else if($layout_select == 3) { ?>
                                    <div>
                                        <?php if($img_1) { ?>
                                            <img src="img/news/<?=$img_1?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_2) { ?>
                                            <img src="img/news/<?=$img_2?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                <?php } else if($layout_select == 4) { ?>
                                    <div>
                                        <?php if($img_1) { ?>
                                            <img src="img/news/<?=$img_1?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_2) { ?>
                                            <img src="img/news/<?=$img_2?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                <?php } else if($layout_select == 5) { ?>
                                    <div>
                                        <?php if($img_1) { ?>
                                            <img src="img/news/<?=$img_1?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_2) { ?>
                                            <img src="img/news/<?=$img_2?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if($img_3) { ?>
                                            <img src="img/news/<?=$img_3?>" class="modal-img" alt="Image">
                                        <?php } else { ?>
                                            <div>ข้อมูลขาดหาย</div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-8 mb-0">
                                <p><strong>ข้อมูล</strong></p>
                                <p class="mt-0"><?=$news_detail?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editNewsModal<?=$news_id?>" tabindex="-1" aria-labelledby="editNewsModalLabel<?=$news_id?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNewsModalLabel<?=$news_id?>">แก้ไขข่าว</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="fn/fn_editnews.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="news_name" class="form-label">ชื่อข่าว</label>
                                <input type="text" class="form-control" id="news_name" name="news_name" value="<?=$news_name?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="news_detail" class="form-label">ข้อมูลข่าวข่าว</label>
                                <textarea class="form-control" id="news_detail" name="news_detail" required><?=$news_detail?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="news_delay" class="form-label">ความเร็วที่ใช้ในการเปลี่ยนภาพ (วินาที)</label>
                                    <select class="form-select" id="news_delay" name="news_delay" required>
                                    <option selected disabled>เลือกDelay</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                </select>
                            </div>
                            <input type="hidden" name="news_id" value="<?=$news_id?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php 
            }
        } 
    ?>
        <div class="card add-card">
            <button type="button" class="add-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewsModal">+</button>
        </div>
    </div>

    <!-- Add News Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">เพิ่มข่าว</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="fn/fn_addnews.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="news_name" class="form-label">ชื่อข่าว</label>
                            <input type="text" class="form-control" id="news_name" name="news_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="news_detail" class="form-label">ข้อมูลข่าวข่าว</label>
                            <textarea class="form-control" id="news_detail" name="news_detail" required></textarea>
                        </div>
                        <div class="mb-3">
                                <label for="news_delay" class="form-label">ความเร็วที่ใช้ในการเปลี่ยนภาพ (วินาที)</label>
                                    <select class="form-select" id="news_delay" name="news_delay" required>
                                    <option selected disabled>เลือกDelay</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                </select>
                            </div>
                        <div class="mb-3">
                            <label for="layout_select" class="form-label">เลือก Layout</label>
                            <select class="form-select" id="layout_select" name="layout_select" required>
                                <option selected disabled>เลือก Layout</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div id="layout-template-section" class="mb-3 grid"></div>
                        <div id="image-select-section" class="mb-3">
                            <!-- Dropdowns for image selection will be generated here -->
                        </div>
                        <!-- Hidden inputs to store selected image IDs -->
                        <div id="hidden-inputs"></div>
                        <input type="hidden" id="selected_layout" name="selected_layout">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึกข่าว</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        var images = <?php echo json_encode($images); ?>;

        document.getElementById('layout_select').addEventListener('change', function() {
            var selectedLayout = this.value;
            var layoutTemplateSection = document.getElementById('layout-template-section');
            var imageSelectSection = document.getElementById('image-select-section');
            layoutTemplateSection.className = 'mb-3 grid layout-' + selectedLayout;

            var gridHtml = '';
            var imageSelectHtml = '';
            var hiddenInputsHtml = '';

            if (selectedLayout == '1') {
                gridHtml += '<div id="grid-1">2160 x 3840 (1)</div>';
                imageSelectHtml += generateImageSelectHtml(1);
                hiddenInputsHtml += '<input type="hidden" name="image_id_1" id="hidden_input_1" >';
            } else if (selectedLayout == '2') {
                gridHtml += '<div id="grid-1">540 x 3840 (1)</div><div id="grid-2">540 x 3840 (2)</div><div id="grid-3">540 x 3840(3)</div><div id="grid-4">540 x 3840(4)</div>';
                imageSelectHtml += generateImageSelectHtml(4);
                hiddenInputsHtml += '<input type="hidden" name="image_id_1" id="hidden_input_1">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_2" id="hidden_input_2">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_3" id="hidden_input_3">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_4" id="hidden_input_4">';
            } else if (selectedLayout == '3') {
                gridHtml += '<div id="grid-1">540 x 3840 (1)</div><div id="grid-2">1620 x 3840 (2)</div>';
                imageSelectHtml += generateImageSelectHtml(2);
                hiddenInputsHtml += '<input type="hidden" name="image_id_1" id="hidden_input_1">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_2" id="hidden_input_2">';
            } else if (selectedLayout == '4') {
                gridHtml += '<div id="grid-1">1620 x 3840  (1)</div><div id="grid-2">540 x 3840 (2)</div>';
                imageSelectHtml += generateImageSelectHtml(2);
                hiddenInputsHtml += '<input type="hidden" name="image_id_1" id="hidden_input_1">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_2" id="hidden_input_2">';
            } else if (selectedLayout == '5') {
                gridHtml += '<div id="grid-1">1080 x 1920(1)</div><div id="grid-2">1080 x 1920(2)</div><div id="grid-3">2160 x 1920(3)</div>';
                imageSelectHtml += generateImageSelectHtml(3);
                hiddenInputsHtml += '<input type="hidden" name="image_id_1" id="hidden_input_1">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_2" id="hidden_input_2">';
                hiddenInputsHtml += '<input type="hidden" name="image_id_3" id="hidden_input_3">';
            }

            layoutTemplateSection.innerHTML = gridHtml;
            imageSelectSection.innerHTML = imageSelectHtml;
            document.getElementById('hidden-inputs').innerHTML = hiddenInputsHtml;

            
            for (var i = 1; i <= (selectedLayout == '1' ? 1 : (selectedLayout == '2' ? 4 : (selectedLayout == '3' ? 2 : (selectedLayout == '4' ? 2 : 3)))); i++) {
                document.getElementById('image_select_' + i).addEventListener('change', function() {
                    var gridId = this.id.split('_')[2];
                    var imgData = images.find(img => img.img_id == this.value);
                    var imgPath = 'img/news/' + imgData.imge;
                    document.getElementById('grid-' + gridId).innerHTML = '<img src="' + imgPath + '" alt="Image">';
                    document.getElementById('hidden_input_' + gridId).value = imgData.img_id;
                });
            }
        });

        function generateImageSelectHtml(count) {
    var html = '';
    for (var i = 1; i <= count; i++) {
        html += '<div class="mb-3">';
        html += '<label for="image_select_' + i + '" class="form-label">เลือก รูป ' + i + '</label>';
        html += '<select class="form-select" id="image_select_' + i + '" name="image_select_' + i + '" required>';
        html += '<option selected disabled>เลือก รูป ' + i + '</option>';
        images.forEach(function(image) {
            html += '<option value="' + image.img_id + '">' + image.img_name + ' ขนาด ' + image.width + 'x' + image.height + '</option>';
        });
        html += '</select>';
        html += '</div>';
    }
    return html;
}


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
    } else if (status === 'showeditsuccess') {
        Swal.fire({
            title: 'แสดงผลบนภาพหน้าจอแล้ว',
            icon: 'success',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    } else if (status === 'errordelay') {
        Swal.fire({
            title: 'บ่ได้ใส่Delay',
            text: 'Delayบ่ได้ใส่',
            icon: 'warning',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    } else if (status === 'errorlayout') {
        Swal.fire({
            title: 'บ่ได้เลือกLayout',
            text: 'เลือกLayout',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.search = ''; 
        });
    }else if (status === 'Addsuccess') {
        Swal.fire({
            title: 'เพิ่มข่าวเสร็จแล้ว!',
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
});
    </script>
</body>
</html>
