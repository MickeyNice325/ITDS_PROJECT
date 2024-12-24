<?php
include('backhouse/fn/config.php');

$sql = "SELECT * FROM news_tb WHERE news_stats = 'show' ORDER BY news_id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$news_items = $result->fetch_all(MYSQLI_ASSOC);

function getImageFileName($img_id, $conn)
{
    if (empty($img_id)) {
        return ''; 
    }

    $sql = "SELECT imge FROM img_tb WHERE img_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $img_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row ? $row['imge'] : ''; 
}

foreach ($news_items as &$news) {
    $news['img_1'] = getImageFileName($news['img_id_1'], $conn);
    $news['img_2'] = getImageFileName($news['img_id_2'], $conn);
    $news['img_3'] = getImageFileName($news['img_id_3'], $conn);
    $news['img_4'] = getImageFileName($news['img_id_4'], $conn);
    $news['img_5'] = getImageFileName($news['img_id_5'], $conn);
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Display</title>
    <style>

    </style>
    <script>
       
       let newsItems = <?= json_encode($news_items); ?>; 
       let currentIndex = 0;
        function displayNews(index) {
            const layout1 = document.querySelector('#grid1');
            const layout2 = document.querySelector('#grid2');

            const currentLayout = index % 2 === 0 ? layout1 : layout2;
            const nextLayout = index % 2 === 0 ? layout2 : layout1;

            const news = newsItems[index];
            currentLayout.style.opacity = 0;
            nextLayout.className = `grid layout-${news.layout_select}`;
            nextLayout.innerHTML = '';

            currentLayout.style.zIndex = 1;
            nextLayout.style.zIndex = 2;
            nextLayout.style.opacity = 1;

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % newsItems.length;
                displayNews(currentIndex);
            }, news.news_delay * 1000);
        }

        window.onload = function () {
            displayNews(currentIndex);
        };

        
    </script>
</head>

<body>
    <div class="container">
        <div id="grid1" class="grid layout-1"></div>
        <div id="grid2" class="grid layout-1"></div>
    </div>
</body>

</html>