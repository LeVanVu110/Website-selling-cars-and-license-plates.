<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Action.php";

header('Content-Type: application/json');

$auction_id = $_GET['id'] ?? 0; // Lấy 'id' từ fetch(`ajax_get_bids.php?id=...`)

if ($auction_id > 0) {
    try {
        $actionModel = new Action();
        $detail = $actionModel->getAuctionDetail($auction_id);
        $bids = $actionModel->getAuctionBids($auction_id);

        if ($detail) {
            echo json_encode([
                'status' => $detail['status'],
                'plate_number' => $detail['plate_number'],
                'bids' => $bids ? $bids : []
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Không tìm thấy phiên']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['bids' => []]);
}
