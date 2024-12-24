<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $img_name = htmlspecialchars($_POST['img_name']);
    $img_detail = htmlspecialchars($_POST['img_detail']);
    $imge = '';
    $width = 0;
    $height = 0;

    $target_dir = "../img/news/";
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            header("Location: ../add_img.php?status=Adderror");
            exit;
        }
    }

    if (isset($_FILES['imge']) && $_FILES['imge']['error'] == 0) {
        $target_file = $target_dir . basename($_FILES["imge"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imge"]["tmp_name"]);
        if ($check !== false) {
            $width = $check[0];  // Width of the image
            $height = $check[1]; // Height of the image

            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["imge"]["tmp_name"], $target_file)) {
                    $imge = htmlspecialchars(basename($_FILES["imge"]["name"]));
                } else {
                    header("Location: ../add_img.php?status=Adderror");
                    exit;
                }
            }
        }
    }

    // Insert news into the database
    $sql = "INSERT INTO img_tb (img_name, img_detail, imge, width, height) VALUES ('$img_name', '$img_detail', '$imge', $width, $height)";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../add_img.php?status=Addsuccess");
        exit;
    } else {
        header("Location: ../add_img.php?status=error");
        exit;
    }
}
?>
