<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Place.php";

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Ngài vui lòng đăng nhập để đấu giá.']);
    exit;
}

$user_id = $_SESSION['user']['user_id'];
$auction_id = (int)($_POST['auction_id'] ?? 0);
$amount = (float)($_POST['amount'] ?? 0);
$type = $_POST['type'] ?? '';

// KIỂM TRA NHANH: Nếu ID = 0 thì báo lỗi ngay tại đây để dễ debug
if ($auction_id <= 0) {
    echo json_encode(['success' => false, 'message' => "Lỗi: ID phiên đấu giá ($auction_id) không hợp lệ."]);
    exit;
}

$placeModel = new Place();

try {
    // Bước 1: Lấy thông tin auction để tính số tiền cuối cùng
    $db = $placeModel->getConnection();
    $sql = "SELECT current_price, bid_step FROM auctions WHERE auctions_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $auction_id);
    $stmt->execute();
    $auction = $stmt->get_result()->fetch_assoc();

    if (!$auction) {
        throw new Exception("Phiên đấu giá (ID: $auction_id) không tồn tại trong hệ thống.");
    }

    // Bước 2: Tính toán số tiền đặt
    $final_bid = ($type === 'increment')
        ? ((float)$auction['current_price'] + $amount)
        : ((float)$auction['current_price'] + (float)$auction['bid_step']);

    // Bước 3: Gọi Model xử lý (Model này đã có Transaction và kiểm tra cọc)
    $result = $placeModel->placeBid($auction_id, $user_id, $final_bid);

    // Trả về kết quả từ Model
    echo json_encode(['success' => ($result['status'] === 'success'), 'message' => $result['message']]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
