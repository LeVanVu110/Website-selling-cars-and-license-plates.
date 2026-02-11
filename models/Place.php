<?php
// require_once __DIR__ . "/db.php";

class Place extends Db
{
    function placeBid($auction_id, $user_id, $bid_amount)
    {
        $db = self::getConnection();

        try {
            // Bật chế độ báo lỗi cho mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            // Bắt đầu Transaction (mysqli)
            $db->begin_transaction();

            // 1. Kiểm tra đặt cọc
            $sql_check = "SELECT deposits_id FROM deposits 
                          WHERE users_id = ? 
                          AND plates_id = (SELECT plates_id FROM auctions WHERE auctions_id = ?)
                          AND status = 1 LIMIT 1";
            $stmt_check = $db->prepare($sql_check);
            $stmt_check->bind_param("ii", $user_id, $auction_id);
            $stmt_check->execute();
            if (!$stmt_check->get_result()->fetch_assoc()) {
                throw new Exception("Ngài chưa đặt cọc cho biển số này.");
            }

            // 2. Lấy giá hiện tại (Khóa dòng để tránh tranh chấp)
            $sql_price = "SELECT current_price, bid_step FROM auctions WHERE auctions_id = ? FOR UPDATE";
            $stmt_price = $db->prepare($sql_price);
            $stmt_price->bind_param("i", $auction_id);
            $stmt_price->execute();
            $auction = $stmt_price->get_result()->fetch_assoc();

            if ($bid_amount < ($auction['current_price'] + $auction['bid_step'])) {
                throw new Exception("Giá đặt phải cao hơn giá hiện tại ít nhất 1 bước giá.");
            }

            // 3. Ghi vào lịch sử Bids
            $sql_bid = "INSERT INTO bids (auctions_id, users_id, bid_amount) VALUES (?, ?, ?)";
            $stmt_bid = $db->prepare($sql_bid);
            $stmt_bid->bind_param("iid", $auction_id, $user_id, $bid_amount);
            $stmt_bid->execute();

            // 4. Cập nhật bảng Auctions
            $sql_update = "UPDATE auctions SET current_price = ?, total_bids = total_bids + 1 WHERE auctions_id = ?";
            $stmt_update = $db->prepare($sql_update);
            $stmt_update->bind_param("di", $bid_amount, $auction_id);
            $stmt_update->execute();

            $db->commit();
            return ["status" => "success", "message" => "Đặt giá thành công!"];
        } catch (Exception $e) {
            $db->rollback();
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
}
