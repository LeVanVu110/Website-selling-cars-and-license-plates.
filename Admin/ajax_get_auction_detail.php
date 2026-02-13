<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";

$auction_id = $_GET['id'] ?? 0;
$actionModel = new Action();

// Lấy lịch sử và thông tin chi tiết phiên
$bids = $actionModel->getAuctionBids($auction_id);
$detail = $actionModel->getAuctionDetail($auction_id);

header('Content-Type: application/json');
echo json_encode([
    'plate_number' => $detail['plate_number'],
    'bids' => $bids
]);
