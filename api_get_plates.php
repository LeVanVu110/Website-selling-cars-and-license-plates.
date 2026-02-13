<?php
// api_get_plates.php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

header('Content-Type: application/json');

$model = new Place();
$province = $_GET['province'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Lấy dữ liệu từ Model
$data = $model->getAllPlates($province, $sort, $page, 20);

// Nếu không có dữ liệu, trả về mảng rỗng
if (!$data) $data = [];

// Gắn thêm Badge vào dữ liệu trước khi trả về JS
foreach ($data as &$item) {
    $item['badge'] = $model->getPlateBadge($item['plate_number']);
}

echo json_encode($data);
exit; // Kết thúc tại đây để không chạy thêm bất kỳ HTML nào