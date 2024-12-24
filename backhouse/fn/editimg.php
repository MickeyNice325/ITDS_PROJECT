<?php

include('config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $img_id = $_POST['img_id'];
    $edit_img_name = $_POST['edit_img_name'];
    $edit_img_detail = $_POST['edit_img_detail'];

    
    $sql = "UPDATE img_tb SET img_name = ?, img_detail = ? WHERE img_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $edit_img_name, $edit_img_detail, $img_id);

    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location: ../add_img.php?status=editsuccess");
        exit;
    } else {
        
        header("Location: ../add_img.php?status=error");
        exit;
    }
}
?>
