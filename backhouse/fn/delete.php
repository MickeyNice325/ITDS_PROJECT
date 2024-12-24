<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement to fetch the image details
    $sql = "SELECT * FROM img_tb WHERE img_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Check for references in news_tb for img_id_1 through img_id_5
        $check_query = "SELECT COUNT(*) AS count FROM news_tb WHERE img_id_1 = ? OR img_id_2 = ? OR img_id_3 = ? OR img_id_4 = ? OR img_id_5 = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "iiiii", $id, $id, $id, $id, $id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        $check_row = mysqli_fetch_assoc($check_result);

        if ($check_row['count'] > 0) {
            // Redirect with error message if references exist
            header("Location: ../add_img.php?status=error");
            exit();
        }

        // Fetch the image details
        $row = mysqli_fetch_assoc($result);
        $imageFile = '../img/news/' . $row['imge'];

        // Delete the image file if it exists
        if (file_exists($imageFile)) {
            unlink($imageFile);
        }

        // Delete the image record
        $delete_query = "DELETE FROM img_tb WHERE img_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "i", $id);
        if (mysqli_stmt_execute($delete_stmt)) {
            header("Location: ../add_img.php?status=Deletedsuccess");
        } else {
            header("Location: ../add_img.php?status=error");
        }
        exit();
    } else {
        header("Location: ../add_img.php?status=Deletednotfound");
        exit();
    }
} else {
    header("Location: ../add_img.php?status=Deletedinvalid");
    exit();
}
?>
