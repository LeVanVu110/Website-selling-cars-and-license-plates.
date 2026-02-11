<?php
// Ngăn các lỗi văn bản làm hỏng JSON
error_reporting(0);
ini_set('display_errors', 0);

require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

$actionModel = new Action();

try {
    if ($id <= 0) throw new Exception("ID không hợp lệ");

    if ($action === 'update_status') {
        // Gọi hàm update trong Model
        $result = $actionModel->updateAuctionStatus($id, $status);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Không thể cập nhật cơ sở dữ liệu");
        }
    } else {
        throw new Exception("Hành động không xác định");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
