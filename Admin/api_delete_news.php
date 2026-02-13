<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . '/models/News.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    $newsModel = new NewsModel();
    // Sử dụng hàm deleteNews đã có trong Model của Ngài
    $result = $newsModel->deleteNews($id);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa bài viết trong Database.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID không hợp lệ.']);
}
