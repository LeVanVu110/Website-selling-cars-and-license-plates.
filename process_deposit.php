<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Ngài vui lòng đăng nhập trước.']);
    exit;
}

$user_id = $_SESSION['user']['user_id'];
$auction_id = (int)($_POST['auction_id'] ?? 0);

if ($auction_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Mã phiên đấu giá không hợp lệ.']);
    exit;
}

$db = (new Db())->getConnection();

try {
    // Kiểm tra xem đã đặt cọc chưa để tránh trùng lặp
    $sql_check = "SELECT deposits_id FROM deposits 
                  WHERE users_id = ? 
                  AND plates_id = (SELECT plates_id FROM auctions WHERE auctions_id = ?) 
                  LIMIT 1";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bind_param("ii", $user_id, $auction_id);
    $stmt_check->execute();

    if ($stmt_check->get_result()->fetch_assoc()) {
        echo json_encode(['success' => true, 'message' => 'Ngài đã có vị thế đặt cọc từ trước.']);
        exit;
    }

    // Thực hiện chèn đặt cọc tự động
    // Tiền cọc mặc định là 40.000.000 và status = 1 (Đã duyệt)
    $sql_insert = "INSERT INTO deposits (users_id, plates_id, deposit_amount, status)
                   SELECT ?, plates_id, 40000000, 1 
                   FROM auctions WHERE auctions_id = ?";

    $stmt_insert = $db->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $auction_id);

    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Xác lập vị thế thành công! Giờ Ngài có thể đấu giá.']);
    } else {
        throw new Exception("Không thể ghi nhận đặt cọc.");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
