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
    public function getPlateById($id)
    {
        $db = self::getConnection();
        $id = (int)$id;
        $sql = "SELECT * FROM plates WHERE plates_id = $id";
        $result = $db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    // Thêm vào class Place trong file models/Place.php
    public function searchPlates($keyword)
    {
        $db = self::getConnection();
        // Tìm kiếm theo biển số (plate_number) hoặc tỉnh thành (province)
        $sql = "SELECT * FROM plates WHERE plate_number LIKE ? OR province LIKE ? AND status = 1";
        $stmt = $db->prepare($sql);
        $search = "%{$keyword}%";
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Thêm/Sửa trong class Place (models/Place.php)
    public function filterPlates($keyword = '', $province = '')
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM plates WHERE status = 1";
        $params = [];
        $types = "";

        // Lọc theo từ khóa (nếu có)
        if (!empty($keyword)) {
            $sql .= " AND (plate_number LIKE ?)";
            $params[] = "%$keyword%";
            $types .= "s";
        }

        // Lọc theo tỉnh thành (nếu có và không phải "Tất cả")
        if (!empty($province) && $province !== 'Tất cả Tỉnh Thành') {
            $sql .= " AND province = ?";
            $params[] = $province;
            $types .= "s";
        }

        $sql .= " ORDER BY plates_id DESC";

        $stmt = $db->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    /// ---------------------------------------- Admin -------------------------------------------
    // 1. XUẤT (Lấy toàn bộ danh sách cho Admin - không phân trang để dễ quản lý hoặc phân trang tùy ý)
    public function getAllPlatesAdmin()
    {
        $db = self::getConnection();
        $sql = "SELECT * FROM plates ORDER BY plates_id DESC";
        $result = $db->query($sql);
        $plates = [];
        while ($row = $result->fetch_assoc()) {
            $plates[] = $row;
        }
        return $plates;
    }

    // 2. THÊM BIỂN SỐ MỚI
    public function addPlate($plate_number, $province, $price, $status = 1)
    {
        $db = self::getConnection();
        $sql = "INSERT INTO plates (plate_number, province, starting_price, status) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssdi", $plate_number, $province, $price, $status);
        return $stmt->execute();
    }

    // 3. SỬA BIỂN SỐ
    public function updatePlate($id, $plate_number, $province, $price, $status)
    {
        $db = self::getConnection();
        $sql = "UPDATE plates SET plate_number = ?, province = ?, starting_price = ?, status = ? WHERE plates_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssdii", $plate_number, $province, $price, $status, $id);
        return $stmt->execute();
    }

    // 4. XÓA BIỂN SỐ
    public function deletePlate($id)
    {
        $db = self::getConnection();
        $sql = "DELETE FROM plates WHERE plates_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
