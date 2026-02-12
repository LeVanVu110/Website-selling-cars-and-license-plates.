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
    // Lấy danh sách biển số với các bộ lọc
    public function getAllPlates($province = '', $sort = 'newest', $page = 1, $limit = 8)
    {
        $db = self::getConnection();
        $offset = ($page - 1) * $limit;

        $where = "WHERE 1=1";
        if (!empty($province)) {
            $where .= " AND province = '" . $db->real_escape_string($province) . "'";
        }

        $orderBy = "created_at DESC";
        if ($sort == 'price-asc') $orderBy = "starting_price ASC";
        if ($sort == 'price-desc') $orderBy = "starting_price DESC";

        $sql = "SELECT * FROM plates $where ORDER BY $orderBy LIMIT ? OFFSET ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số để làm phân trang
    public function countTotalPlates($province = '')
    {
        $db = self::getConnection();
        $where = "WHERE 1=1";
        if (!empty($province)) {
            $where .= " AND province = '" . $db->real_escape_string($province) . "'";
        }
        $sql = "SELECT COUNT(*) as total FROM plates $where";
        return $db->query($sql)->fetch_assoc()['total'];
    }

    // Hàm xác định Badge dựa trên số (Logic phong thủy)
    public function getPlateBadge($plate_number)
    {
        // 1. Làm sạch số (Xóa dấu chấm, dấu gạch ngang) -> ví dụ: 30K12345
        $cleanNumber = str_replace(['.', '-'], '', $plate_number);
        $length = strlen($cleanNumber);

        // 2. Kiểm tra Ngũ Quý (5 số cuối giống hệt nhau)
        if (preg_match('/(\d)\1{4}$/', $cleanNumber)) return "Ngũ Quý";

        // 3. Kiểm tra Tứ Quý (4 số cuối giống hệt nhau)
        if (preg_match('/(\d)\1{3}$/', $cleanNumber)) return "Tứ Quý";

        // 4. Kiểm tra Sảnh Tiến (4 hoặc 5 số cuối tăng dần)
        $last5 = substr($cleanNumber, -5);
        if (strpos('0123456789', $last5) !== false) return "Sảnh Tiến";

        // 5. Kiểm tra Số Gánh (Dạng ABA hoặc ABABA)
        // Lấy 5 số cuối để kiểm tra đối xứng
        if ($length >= 5) {
            $tail = substr($cleanNumber, -5);
            // Kiểm tra cặp đối xứng: số thứ 1 = số thứ 5, số thứ 2 = số thứ 4
            if ($tail[0] == $tail[4] && $tail[1] == $tail[3]) {
                return "Số Gánh";
            }
        }

        return "Đại Cát";
    }
}
