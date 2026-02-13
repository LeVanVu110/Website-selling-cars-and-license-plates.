<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . '/models/News.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $newsModel = new NewsModel();

    // Gọi hàm đã có sẵn trong Model của Ngài
    $news = $newsModel->getNewsById($id);

    if ($news) {
        // Trả về dữ liệu thành công
        echo json_encode($news);
    } else {
        // Trường hợp không tìm thấy bài viết
        http_response_code(404);
        echo json_encode(['message' => 'Không tìm thấy kiệt tác yêu cầu.']);
    }
} else {
    // Trường hợp thiếu ID
    http_response_code(400);
    echo json_encode(['message' => 'Yêu cầu không hợp lệ.']);
}
