<?php
// require_once __DIR__ . "/db.php";

class Action extends Db
{
    public function getAllAuctions()
    {
        $db = self::getConnection();
        // Lấy thông tin phiên đấu giá
        $sql = "SELECT a.*, p.plate_number, p.starting_price 
            FROM auctions a 
            JOIN plates p ON a.plates_id = p.plates_id 
            ORDER BY 
                CASE 
                    WHEN a.status = 'active' THEN 1 
                    WHEN a.status = 'upcoming' THEN 2 
                    ELSE 3 
                END ASC, a.start_time ASC";
        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Hàm lấy chi tiết phiên đấu giá
    function getAuctionDetail($auction_id)
    {
        $db = self::getConnection();

        $sql = "SELECT a.*, p.plate_number, p.starting_price, p.bid_step, 
                (SELECT fullname FROM users WHERE user_id = (SELECT users_id FROM bids WHERE auctions_id = a.auctions_id ORDER BY bid_amount DESC LIMIT 1)) as highest_bidder_name
                FROM auctions a
                JOIN plates p ON a.plates_id = p.plates_id
                WHERE a.auctions_id = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Hàm lấy lịch sử đấu giá (Dòng 24 đã bỏ tham số $conn)
    function getBidHistory($auction_id)
    {
        $db = self::getConnection();

        $sql = "SELECT b.bid_amount, b.created_at, u.fullname 
                FROM bids b 
                JOIN users u ON b.users_id = u.user_id 
                WHERE b.auctions_id = ? 
                ORDER BY b.bid_amount DESC LIMIT 5";

        $stmt = $db->prepare($sql);

        // Kiểm tra nếu SQL lỗi
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        return $history;
    }
    // Trong class Action extends Db
    public function getWinner($auction_id)
    {
        $db = self::getConnection();
        // Tìm người có mức giá cao nhất trong bảng bids
        $sql = "SELECT b.users_id, b.bid_amount, u.fullname, u.balance 
            FROM bids b 
            JOIN users u ON b.users_id = u.user_id 
            WHERE b.auctions_id = ? 
            ORDER BY b.bid_amount DESC LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function processWinner($auction_id)
    {
        $db = self::getConnection();
        $winner = $this->getWinner($auction_id);

        if ($winner) {
            $userId = $winner['users_id'];
            $amount = $winner['bid_amount'];
            $currentBalance = $winner['balance'];

            if ($currentBalance >= $amount) {
                // Trừ tiền user
                $newBalance = $currentBalance - $amount;
                $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("di", $newBalance, $userId);
                return $updateStmt->execute();
            }
        }
        return false;
    }
    // Lấy tổng số người tham gia duy nhất trong một phiên đấu giá
    public function getParticipantCount($auction_id)
    {
        $db = self::getConnection();
        $sql = "SELECT COUNT(DISTINCT users_id) as total_users FROM bids WHERE auctions_id = ?";

        $stmt = $db->prepare($sql);
        if (!$stmt) return 0;

        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total_users'] ?? 0;
    }
    /// --------------------------------------------------------- Admin -----------------------------------------
    public function getAuctionsByStatus($status)
    {
        $db = self::getConnection();

        if ($status === 'ended') {
            // Lấy cả phiên đã hết giờ và phiên đã thu tiền xong
            $sql = "SELECT a.*, p.plate_number, p.starting_price 
                FROM auctions a 
                JOIN plates p ON a.plates_id = p.plates_id 
                WHERE a.status IN ('completed', 'settled')
                ORDER BY a.end_time DESC";
            $result = $db->query($sql);
        } else {
            // Lấy chính xác status: 'active' hoặc 'upcoming'
            $sql = "SELECT a.*, p.plate_number, p.starting_price 
                FROM auctions a 
                JOIN plates p ON a.plates_id = p.plates_id 
                WHERE a.status = ?
                ORDER BY a.start_time ASC";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $status);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function createAuction($data)
    {
        $db = self::getConnection();

        // SQL khớp chính xác với file auctions (5).sql của Ngài
        $sql = "INSERT INTO auctions (plates_id, start_time, end_time, current_price, total_bids, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($sql);

        // total_bids mặc định là 0 khi mới tạo
        $totalBids = 0;

        // Ràng buộc tham số: 
        // i: int (plates_id, total_bids)
        // s: string (start_time, end_time, status)
        // d: double/decimal (current_price)
        $stmt->bind_param(
            "issdis",
            $data['plates_id'],
            $data['start_time'],
            $data['end_time'],
            $data['current_price'],
            $totalBids,
            $data['status']
        );

        if ($stmt->execute()) {
            return $db->insert_id;
        } else {
            // Ghi log lỗi nếu cần: error_log($stmt->error);
            return false;
        }
    }
    public function getAvailablePlates()
    {
        $db = self::getConnection();

        // 1. plates_id: Khóa chính của bảng plates
        // 2. plate_number: Số biển
        // 3. starting_price: Giá khởi điểm gốc trong bảng plates
        // 4. Logic: Chỉ lấy những biển số KHÔNG nằm trong các phiên đấu giá đang chạy (active) hoặc sắp chạy (upcoming)
        $sql = "SELECT plates_id, plate_number, starting_price 
            FROM plates 
            WHERE plates_id NOT IN (
                SELECT plates_id 
                FROM auctions 
                WHERE status IN ('active', 'upcoming')
            )";

        $result = $db->query($sql);

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
