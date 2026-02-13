<?php
// Tạm thời bật lỗi lên để nếu còn lỗi 500, bạn sẽ thấy thông báo lỗi cụ thể thay vì chỉ thấy số 500
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";

header('Content-Type: application/json');

// QUAN TRỌNG: Phải khởi tạo Object thì mới gọi được hàm
$actionModel = new Action();

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

try {
    if ($id <= 0) throw new Exception("ID không hợp lệ");

    if ($action === 'update_status') {
        $status = $_POST['status'] ?? '';
        $result = $actionModel->updateAuctionStatus($id, $status);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Lỗi cập nhật trạng thái");
        }
    } elseif ($action === 'extend_auction') {
        // Lấy kết nối database từ model
        $db = $actionModel->getConnection();

        // SQL: Cộng thêm 30 phút vào end_time hiện tại
        $sql = "UPDATE auctions 
SET end_time = DATE_ADD(GREATEST(end_time, NOW()), INTERVAL 10 MINUTE) 
WHERE auctions_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) throw new Exception("Lỗi chuẩn bị SQL: " . $db->error);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Lỗi thực thi SQL: " . $stmt->error);
        }
    } else {
        throw new Exception("Hành động không hợp lệ: " . $action);
    }
} catch (Exception $e) {
    // Trả về lỗi định dạng JSON để JavaScript catch được
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;
