<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actionModel = new Action();

    // Lấy dữ liệu từ POST
    // Trong file xử lý AJAX
    $data = [
        'plates_id'     => (int)$_POST['plates_id'],
        'start_time'    => $_POST['start_time'],
        'end_time'      => $_POST['end_time'], // Lấy trực tiếp từ POST thay vì tự cộng 4 tiếng
        'current_price' => (float)$_POST['current_price'], // Tên biến gửi từ JS là current_price
        'status'        => $_POST['status'] // Tên biến gửi từ JS là status ('active' hoặc 'upcoming')
    ];

    $result = $actionModel->createAuction($data);

    if ($result) {
        echo json_encode(['success' => true, 'id' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn cơ sở dữ liệu']);
    }
}
