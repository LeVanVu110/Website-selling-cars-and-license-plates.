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

try {
    if ($id <= 0) throw new Exception("ID không hợp lệ");

    if ($action === 'update_status') {
        $status = $_POST['status'] ?? '';
        $result = $actionModel->updateAuctionStatus($id, $status);
        if ($result) echo json_encode(['success' => true]);
        else throw new Exception("Lỗi cập nhật trạng thái");
    } elseif ($action === 'extend_auction') {
        // Logic gia hạn 30 phút
        $db = $actionModel->getConnection();

        // SQL: Cộng thêm 30 phút vào end_time hiện tại
        $sql = "UPDATE auctions SET end_time = DATE_ADD(end_time, INTERVAL 30 MINUTE) WHERE auctions_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Lỗi thực thi lệnh SQL gia hạn");
        }
    } else {
        throw new Exception("Hành động không hợp lệ: " . $action);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
