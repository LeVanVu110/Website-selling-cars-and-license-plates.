<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . '/models/News.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsModel = new NewsModel();
    $newsId = $_POST['news_id'] ?? 0;

    // Lấy dữ liệu cũ để giữ lại ảnh nếu không upload ảnh mới
    $currentNews = $newsModel->getNewsById($newsId);
    $thumbnailPath = $_POST['current_thumbnail'] ?? $currentNews['thumbnail'];

    // Xử lý upload ảnh mới (nếu có)
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDirOutside = dirname(__DIR__) . '/uploads/news/';
        $uploadDirInside = __DIR__ . '/uploads/news/';

        $newFileName = md5(time() . $_FILES['thumbnail']['name']) . '.' . pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDirOutside . $newFileName)) {
            copy($uploadDirOutside . $newFileName, $uploadDirInside . $newFileName);
            $thumbnailPath = 'uploads/news/' . $newFileName;
        }
    }

    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? 'xe-sang';
    $subtitle = $title . " | & | Tinh Hoa Heritage";
    $summary = mb_substr(strip_tags($content), 0, 150, "UTF-8") . "...";

    $result = $newsModel->updateNews($newsId, $title, $subtitle, $summary, $content, $thumbnailPath, $category, 1);

    echo json_encode(['success' => $result]);
}
